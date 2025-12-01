<?php

namespace Modules\Resident\App\Http\Services;

use App\Constants\PermissionName;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Resident\App\Models\ResidentForm;
use Yajra\DataTables\Facades\DataTables;

class ResidentFormService
{
    public function get()
    {
        $query = ResidentForm::select(['id', 'name'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::resident_form_edit())) {
                    $btn .= '<a href="' . route('admin.resident.form.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::resident_form_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.resident.form.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($data)
    {
        $now = now();
        foreach ($data as $item) {
            $dataToInsert[] = [
                'name' => $item,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::beginTransaction();
        try {
            $residentForm = ResidentForm::insert($dataToInsert);

            DB::commit();
            return $residentForm;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(ResidentForm $residentForm, $data)
    {
        DB::beginTransaction();
        try {
            $residentForm->update($data);

            DB::commit();
            return $residentForm;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(ResidentForm $residentForm)
    {
        DB::beginTransaction();
        try {
            $delete = $residentForm->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
