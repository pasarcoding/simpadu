<?php

namespace Modules\Resident\App\Http\Services;

use App\Constants\PermissionName;
use App\Exports\ResidentExport;
use App\Exports\ResidentTemplateExport;
use App\Imports\ResidentImport;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Resident\App\Models\Resident;
use Modules\Resident\App\Models\ResidentFormValue;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yajra\DataTables\Facades\DataTables;

class ResidentService
{
    public function get(Request $request)
    {
        $query = Resident::select(['id', 'family_card_number', 'national_id', 'full_name', 'gender', 'birth_place', 'birth_date', 'rt', 'rw', 'image']);

        if ($request->input('village')) {
            $query->where(DB::raw('LOWER(hamlet_village)'), strtolower($request->input('village')));
        }

        if ($request->input('age') && is_numeric($request->input('age'))) {
            $query->where(DB::raw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE())'), '=', $request->input('age'));
            $query->whereNotNull('birth_date');

            Log::info('SQL Query Umur: ' . $query->toSql());
            Log::info('Bindings Umur: ' . json_encode($query->getBindings()));
        }

        $query = $query->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('gender', function ($row) {
                return getGenderList()[$row->gender];
            })
            ->addColumn('birth', function ($row) {
                $birthDate = $row->birth_date ? Carbon::parse($row->birth_date)->format('d F Y') : '-';
                return $row->birth_place . ', ' . $birthDate;
            })
            ->addColumn('rt_rw', function ($row) {
                return $row->rt . '/' . $row->rw;
            })
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" class="rounded-3 object-fit-cover" style="width:4rem; height: 4rem;">';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::resident_detail_view())) {
                    $btn .= '<a href="' . route('admin.resident.detail', $row->id) . '" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-eye"></i></a>';
                }

                if (auth()->user()->can(PermissionName::resident_edit())) {
                    $btn .= ' <a href="' . route('admin.resident.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::resident_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.resident.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        $newImage = null;
        if (isset($data['image']) && $data['image']->isValid()) {
            $newImage = $data['image']->store('residents', 'public');
            $data['image'] = $newImage;
        }

        $residentForms = $data['resident_forms'];
        unset($data['resident_forms']);

        DB::beginTransaction();
        try {
            $data['other_job'] = $data['job'] == 'lainnya' ? $data['other_job'] : null;
            $resident = Resident::create($data);

            $residentFormProcessed = [];
            $now = now();
            foreach ($residentForms as $id => $value) {
                $residentFormProcessed[] = [
                    'resident_id' => $resident->id,
                    'resident_form_id' => $id,
                    'value' => $value,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            ResidentFormValue::upsert(
                $residentFormProcessed,
                ['resident_id', 'resident_form_id'],
                ['value', 'updated_at']
            );

            DB::commit();
            return $resident;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function import($data)
    {
        $import = new ResidentImport();

        $dynamicFormMapping = $import->getDynamicFormMapping();
        $now = now();

        DB::beginTransaction();
        try {
            Excel::import($import, $data['file']);

            $failures = $import->failures();
            if ($failures->isNotEmpty()) {
                DB::rollBack();

                $formattedErrors = [];
                foreach ($failures as $failure) {
                    $attribute = $failure->attribute();
                    $row = $failure->row();
                    $errors = $failure->errors();

                    foreach ($errors as $message) {
                        $columnName = str_replace('_', ' ', $attribute);
                        // $formattedMessage = "Baris {$row} (Kolom " . ucwords($columnName) . "): {$message}";
                        $formattedMessage = $message;

                        $formattedErrors[$attribute][] = $formattedMessage;
                    }
                }

                throw ValidationException::withMessages($formattedErrors);
            }

            $rows = $import->getRows();
            $errorNikDuplicateMessages = [];

            $nikDuplicateGroups = $rows->map(function ($row, $index) {
                return [
                    'nik' => trim($row['NIK*']),
                    'row_index' => $index + 2,
                ];
            })->groupBy('nik')->filter(fn($group) => $group->count() > 1);

            if ($nikDuplicateGroups->isNotEmpty()) {
                foreach ($nikDuplicateGroups as $nik => $group) {
                    foreach ($group as $item) {
                        $rowNum = $item['row_index'];
                        $errorNikDuplicateMessages['NIK*'][] = "The " . $rowNum . ". n i k* has already been taken.";
                    }
                }
            }

            if (!empty($errorNikDuplicateMessages)) {
                DB::rollBack();
                throw ValidationException::withMessages($errorNikDuplicateMessages);
            }

            $rows->chunk(500)->each(function ($chunk) use ($dynamicFormMapping, $now) {
                $residentToInsert = [];
                $formValueToInsert = [];
                $nikChunk = [];

                foreach ($chunk as $row) {
                    $nik = trim($row['NIK*']);

                    $tanggalLahir = null;
                    if (isset($row['Tanggal Lahir*']) && is_numeric($row['Tanggal Lahir*'])) {
                        try {
                            $tanggalLahir = Date::excelToDateTimeObject($row['Tanggal Lahir*'])->format('Y-m-d');
                        } catch (\Exception $e) {
                        }
                    }

                    $tanggalPindah = null;
                    if (isset($row['Tanggal Pindah/Keluar']) && is_numeric($row['Tanggal Pindah/Keluar'])) {
                        try {
                            $tanggalPindah = Date::excelToDateTimeObject($row['Tanggal Pindah/Keluar'])->format('Y-m-d');
                        } catch (\Exception $e) {
                        }
                    }

                    $residentToInsert[] = [
                        'national_id' => $nik,
                        'family_card_number' => trim($row['Nomor KK*']),
                        'full_name' => $row['Nama Lengkap*'],
                        'gender' => array_flip(getGenderList())[$row['Jenis Kelamin*']],
                        'birth_place' => $row['Tempat Lahir*'],
                        'birth_date' => $tanggalLahir,
                        'religion' => array_flip(getReligionList())[$row['Agama*']],
                        'job' => array_flip(getJobList())[$row['Pekerjaan*']],
                        'last_education' => array_flip(getEducationList())[$row['Pendidikan Terakhir*']],
                        'marital_status' => array_flip(getMaritalStatusList())[$row['Status Pernikahan*']],
                        'family_relationship' => array_flip(getFamilyRelationshipList())[$row['Hubungan Keluarga*']],
                        'address' => $row['Alamat*'],
                        'rt' => trim($row['Rt*']),
                        'rw' => trim($row['Rw*']),
                        'hamlet_village' => $row['Dusun/Kelurahan'],
                        'death_status' => array_flip(getDeathStatusList())[$row['Status Kematian*']],
                        'citizenship' => array_flip(getCitizenshipList())[$row['Kewarganegaraan*']],
                        'transfer_date' => $tanggalPindah,
                    ];

                    $nikChunk[] = $nik;
                }

                if (!empty($residentToInsert)) {
                    Resident::insert($residentToInsert);

                    $residentMap = Resident::whereIn('national_id', $nikChunk)
                        ->pluck('id', 'national_id')
                        ->toArray();

                    foreach ($chunk as $row) {
                        $nik = trim($row['NIK*']);

                        $residentId = $residentMap[$nik] ?? null;
                        if (!$residentId) continue;

                        foreach ($dynamicFormMapping as $name => $id) {
                            $formValueToInsert[] = [
                                'resident_id' => $residentId,
                                'resident_form_id' => $id,
                                'value' => trim($row[$name] ?? ''),
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }

                if (!empty($formValueToInsert)) {
                    ResidentFormValue::insert($formValueToInsert);
                }
            });

            DB::commit();
            return $import;
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new ResidentExport($request), 'data_penduduk_' . time() . '.xlsx');
    }

    public function export_template()
    {
        return Excel::download(new ResidentTemplateExport, 'template_penduduk.xlsx');
    }

    public function update(Resident $resident, $data)
    {
        $oldImage = $resident->getRawOriginal('image');
        $newImage = null;

        if (isset($data['image']) && $data['image']->isValid()) {
            $newImage = $data['image']->store('residents', 'public');
            $data['image'] = $newImage;
        }

        $residentForms = $data['resident_forms'];
        unset($data['resident_forms']);

        DB::beginTransaction();
        try {
            $data['other_job'] = $data['job'] == 'lainnya' ? $data['other_job'] : null;
            $resident->update($data);

            $residentFormProcessed = [];
            $now = now();
            foreach ($residentForms as $id => $value) {
                $residentFormProcessed[] = [
                    'resident_id' => $resident->id,
                    'resident_form_id' => $id,
                    'value' => $value,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            ResidentFormValue::upsert(
                $residentFormProcessed,
                ['resident_id', 'resident_form_id'],
                ['value', 'updated_at']
            );

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return $resident;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function destroy(Resident $resident)
    {
        $image = $resident->getRawOriginal('image');

        DB::beginTransaction();
        try {
            $delete = $resident->delete();

            if ($delete && $image) {
                Storage::disk('public')->delete($image);
            }

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function reset()
    {
        $imagePath = 'residents';

        DB::beginTransaction();
        try {
            $delete = Resident::query()->delete();

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->deleteDirectory($imagePath);
                Storage::disk('public')->makeDirectory($imagePath);
            }

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
