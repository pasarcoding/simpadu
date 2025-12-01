<?php

namespace Modules\ELetter\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Modules\ELetter\App\Models\ELetterSubmission;
use Modules\ELetter\App\Models\ELetterTemplate;
use Modules\Setting\App\Http\Services\SettingService;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

class ELetterSubmissionService
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function get()
    {
        $query = ELetterSubmission::select(['id', 'e_letter_template_id', 'resident_id', 'national_id', 'letter_number', 'list_variable_with_values', 'whatsapp_number', 'status'])
            ->with(['e_letter_template', 'resident'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('resident_name', function ($row) {
                if ($row->resident) {
                    return $row->resident->full_name;
                }

                return '<i class="text-danger">Bukan Penduduk</i>';
            })
            ->editColumn('status', function ($row) {
                $statusColor = [
                    'submitted' => 'info',
                    'verification' => 'warning',
                    'signed' => 'primary',
                    'completed' => 'success',
                    'rejected' => 'danger',
                ];

                return '<span class="badge bg-' . $statusColor[$row['status']] . '">' . getSubmissionStatusList()[$row['status']] . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button class="btn btn-sm btn-secondary" title="Download" data-bs-toggle="modal" data-bs-target="#downloadModal" data-download-url="' . route('admin.e-letter.submission.download', $row->id) . '"><i class="ti ti-download"></i></button>';

                if ($row->status == 'completed') {
                    $btn .= ' <a href="https://wa.me/' . $row->whatsapp_number . '?text=' . $this->settingService->e_letter_parse_message($row, 'completed') . '" target="_blank" class="btn btn-sm btn-warning" title="Kirim Pesan"><i class="ti ti-brand-whatsapp"></i></a>';
                } elseif ($row->status == 'rejected') {
                    $btn .= ' <a href="https://wa.me/' . $row->whatsapp_number . '?text=' . $this->settingService->e_letter_parse_message($row, 'rejected') . '" target="_blank" class="btn btn-sm btn-warning" title="Kirim Pesan"><i class="ti ti-brand-whatsapp"></i></a>';
                }

                if (auth()->user()->can(PermissionName::e_letter_submission_detail_view())) {
                    $btn .= ' <a href="' . route('admin.e-letter.submission.detail', $row->id) . '" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-eye"></i></a>';
                }

                if (auth()->user()->can(PermissionName::e_letter_submission_edit())) {
                    $btn .= ' <a href="' . route('admin.e-letter.submission.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::e_letter_submission_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.e-letter.submission.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['resident_name', 'status', 'action'])
            ->make(true);
    }


    public function update(ELetterSubmission $eLetterSubmission, $data)
    {
        $formDatas = $data['form'];
        $formDataProcess = [];
        $oldFiles = [];
        $newFiles = [];

        $eLetterTemplate = ELetterTemplate::find($eLetterSubmission->e_letter_template_id);
        $listVariables = json_decode($eLetterTemplate->list_variables);
        $listVariableWithValues = collect(json_decode($eLetterSubmission->list_variable_with_values))
            ->keyBy('name');

        foreach ($listVariables as $item) {
            $name = $item->name;
            $oldValue = $listVariableWithValues->get($name)->value ?? null;

            if (isset($formDatas[$name])) {
                if ($formDatas[$name] instanceof UploadedFile) {
                    if (isset($formDatas[$name]) && $formDatas[$name]->isValid()) {
                        $newFile = $formDatas[$name]->store('e_letter_submission', 'public');
                        $item->value = $newFile;
                        $newFiles[] = $newFile;
                        $oldFiles[] = $oldValue;
                    } else {
                        $item->value = $oldValue;
                    }
                } else {
                    $item->value = $formDatas[$name];
                }
            } else {
                $item->value = $oldValue;
            }

            $formDataProcess[] = $item;
        }

        unset($data['form']);

        DB::beginTransaction();
        try {
            $data['list_variable_with_values'] = json_encode($formDataProcess);
            $eLetterSubmission->update($data);

            foreach ($oldFiles as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }

            DB::commit();
            return $eLetterSubmission;
        } catch (Exception $e) {
            DB::rollBack();

            foreach ($newFiles as $item) {
                Storage::disk('public')->delete($item);
            }

            throw $e;
        }
    }

    public function destroy(ELetterSubmission $eLetterSubmission)
    {
        $oldData = $eLetterSubmission;

        DB::beginTransaction();
        try {
            $delete = $eLetterSubmission->delete();

            foreach (json_decode($oldData->list_variable_with_values) as $item) {
                if ($item->format == 'image' && $item->value && Storage::disk('public')->exists($item->value)) {
                    Storage::disk('public')->delete($item->value);
                }
            }

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function download(ELetterSubmission $eLetterSubmission)
    {

        $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($eLetterSubmission->e_letter_template->getRawOriginal('file')));

        try {
            $templateProcessor->setValue(getLetterNumberVaribleTemplate(), $eLetterSubmission->letter_number);

            foreach (json_decode($eLetterSubmission->list_variable_with_values) as $item) {
                if ($item->format == 'text') {
                    $templateProcessor->setValue($item->variable, $item->value);
                } else {
                    $templateProcessor->setImageValue($item->variable, Storage::disk('public')->path($item->value));
                }
            }

            $fileName = $eLetterSubmission->letter_number . '.docx';
            $outputFilePath = 'temp/' . $fileName;
            $outputFullTempPath = Storage::path($outputFilePath);

            $outputDirRelative = dirname($outputFilePath);
            if (!Storage::disk('local')->exists($outputDirRelative)) {
                Storage::disk('local')->makeDirectory($outputDirRelative);
            }

            $templateProcessor->saveAs($outputFullTempPath);

            // return $outputFilePath;
            return $outputFullTempPath;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
