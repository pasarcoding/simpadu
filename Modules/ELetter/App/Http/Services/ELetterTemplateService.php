<?php

namespace Modules\ELetter\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Modules\ELetter\App\Models\ELetterTemplate;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

class ELetterTemplateService
{
    public function get()
    {
        $query = ELetterTemplate::select(['id', 'name', 'last_sequence_number', 'padding_sequence_length', 'list_variables', 'status'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('last_sequence_number', function ($row) {
                return str_pad($row->last_sequence_number, $row->padding_sequence_length, '0', STR_PAD_LEFT);
            })
            ->editColumn('list_variables', function ($row) {
                $data = [];
                foreach (json_decode($row->list_variables) as $i => $item) {
                    $data[] = '<span>' . $item->label . ' (' . $item->format . ')</span>';
                }

                return '<span>' . implode(', ', $data) . '</span>';
            })
            ->editColumn('status', function ($row) {
                $statusColor = [
                    "active" => "success",
                    "nonactive" => "danger",
                ];

                return '<span class="badge bg-' . $statusColor[$row['status']] . '">' . getTemplateStatusList()[$row['status']] . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::e_letter_template_edit())) {
                    $btn .= ' <a href="' . route('admin.e-letter.template.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::e_letter_template_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.e-letter.template.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['list_variables', 'status', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        $newFile = null;
        if (isset($data['file']) && $data['file']->isValid()) {
            $newFile = $data['file']->store('e_letter_template', 'public');
            $data['file'] = $newFile;

            $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($newFile));
            $listVariables = [];
            foreach ($templateProcessor->getVariables() as $item) {
                if ($item == getLetterNumberVaribleTemplate()) {
                    continue;
                }

                $format = '';
                $name = $item;
                $label = $item;

                if (preg_match(getTemplateVaribalePattern(), $item, $matches)) {
                    $format = $matches[1];
                    $name = $matches[2];
                    $label = $matches[3];
                } elseif (preg_match(getTemplateVaribaleNoLabelPattern(), $item, $matches)) {
                    $format = $matches[1];
                    $name = $matches[2];
                    $label = $matches[2];
                }

                if (empty($format)) {
                    Storage::disk('public')->delete($newFile);
                    throw ValidationException::withMessages([
                        'file' => ['Ditemukan format variabel dalam file yang tidak valid.']
                    ]);
                }

                if (!isset($listVariables[$name])) {
                    $listVariables[$name] = [
                        'variable' => $item,
                        'format' => $format,
                        'name' => $name,
                        'label' => $label,
                    ];
                }
            }
            $data['list_variables'] = json_encode(array_values($listVariables));
        }


        DB::beginTransaction();
        try {
            $data['padding_sequence_length'] = strlen($data['last_sequence_number']);
            $eLetterTemplate = ELetterTemplate::create($data);

            DB::commit();
            return $eLetterTemplate;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newFile) {
                Storage::disk('public')->delete($newFile);
            }

            throw $e;
        }
    }

    public function update(ELetterTemplate $eLetterTemplate, $data)
    {
        $oldFile = $eLetterTemplate->getRawOriginal('file');
        $newFile = null;

        if (isset($data['file']) && $data['file']->isValid()) {
            $newFile = $data['file']->store('e_letter_template', 'public');
            $data['file'] = $newFile;

            $templateProcessor = new TemplateProcessor(Storage::disk('public')->path($newFile));
            $listVariables = [];
            foreach ($templateProcessor->getVariables() as $item) {
                if ($item == getLetterNumberVaribleTemplate()) {
                    continue;
                }

                $format = '';
                $name = $item;
                $label = $item;

                if (preg_match(getTemplateVaribalePattern(), $item, $matches)) {
                    $format = $matches[1];
                    $name = $matches[2];
                    $label = $matches[3];
                } elseif (preg_match(getTemplateVaribaleNoLabelPattern(), $item, $matches)) {
                    $format = $matches[1];
                    $name = $matches[2];
                    $label = $matches[2];
                }

                if (empty($format)) {
                    Storage::disk('public')->delete($newFile);
                    throw ValidationException::withMessages([
                        'file' => ['Ditemukan format variabel dalam file yang tidak valid.']
                    ]);
                }

                if (!isset($listVariables[$name])) {
                    $listVariables[$name] = [
                        'variable' => $item,
                        'format' => $format,
                        'name' => $name,
                        'label' => $label,
                    ];
                }
            }
            $data['list_variables'] = json_encode(array_values($listVariables));
        }

        DB::beginTransaction();
        try {
            $eLetterTemplate->update($data);

            if ($newFile && $oldFile) {
                Storage::disk('public')->delete($oldFile);
            }

            DB::commit();
            return $eLetterTemplate;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newFile) {
                Storage::disk('public')->delete($newFile);
            }

            throw $e;
        }
    }

    public function destroy(ELetterTemplate $eLetterTemplate)
    {
        $file = $eLetterTemplate->getRawOriginal('file');

        DB::beginTransaction();
        try {
            $delete = $eLetterTemplate->delete();

            if ($delete && $file) {
                Storage::disk('public')->delete($file);
            }

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
