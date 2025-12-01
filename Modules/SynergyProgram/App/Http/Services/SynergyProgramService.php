<?php

namespace Modules\SynergyProgram\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Gallery\App\Models\Gallery;
use Modules\SynergyProgram\App\Models\SynergyProgram;
use Yajra\DataTables\Facades\DataTables;

class SynergyProgramService
{
    public function get()
    {
        $query = SynergyProgram::select(['id', 'name', 'image'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '"  class="rounded-3 object-fit-cover" style="width: 4rem; height: 4rem;">';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::synergy_program_delete())) {
                    $btn .= '<button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.synergy-program.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        $dataToInsert = [];
        $newImageList = [];
        $now = now();

        foreach ($data as $item) {
            if (isset($item['image']) && $item['image']->isValid()) {
                $newImage = $item['image']->store('synergy_programs', 'public');
                $item['image'] = $newImage;
                $newImageList[] = $newImage;
            }

            $dataToInsert[] = [
                'image' => $item['image'],
                'name' => $item['name'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::beginTransaction();
        try {
            $synergyProgram = SynergyProgram::insert($dataToInsert);

            DB::commit();
            return $synergyProgram;
        } catch (Exception $e) {
            DB::rollBack();

            if (!empty($newImageList)) {
                Storage::disk('public')->delete($newImageList);
            }

            throw $e;
        }
    }

    public function destroy(SynergyProgram $synergyProgram)
    {
        $image = $synergyProgram->getRawOriginal('image');

        DB::beginTransaction();
        try {
            $delete = $synergyProgram->delete();

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
}
