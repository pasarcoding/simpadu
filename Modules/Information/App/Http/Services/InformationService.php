<?php

namespace Modules\Information\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Information\App\Models\Information;
use Yajra\DataTables\Facades\DataTables;

class InformationService
{
    public function get()
    {
        $query = Information::select(['id', 'title', 'slug', 'status', 'user_id', 'thumbnail'])
            ->with('user')
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('thumbnail', function ($row) {
                return '<img src="' . $row->thumbnail . '" class="rounded-3 object-fit-cover" style="width:6rem; height: 4rem;">';
            })
            ->editColumn('status', function ($row) {
                $statusBg = [
                    'publish' => 'bg-success',
                    'arsip' => 'bg-danger'
                ];

                return '<span class="badge ' . $statusBg[$row->status] . '">' . getPusblishStatusList()[$row->status] . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('user.information.detail', $row->slug). '" target="_blank" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-eye"></i></a>';

                if (auth()->user()->can(PermissionName::information_edit())) {
                    $btn .= ' <a href="' . route('admin.information.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::information_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.information.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['thumbnail', 'url', 'status', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        $newImage = null;
        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            $newImage = $data['thumbnail']->store('informations', 'public');
            $data['thumbnail'] = $newImage;
        }

        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $information = Information::create($data);

            DB::commit();
            return $information;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function update(Information $information, $data)
    {
        $oldImage = $information->getRawOriginal('thumbnail');
        $newImage = null;

        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            $newImage = $data['thumbnail']->store('informations', 'public');
            $data['thumbnail'] = $newImage;
        }

        DB::beginTransaction();
        try {
            $information->update($data);

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return $information;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function destroy(Information $information)
    {
        $image = $information->getRawOriginal('thumbnail');

        DB::beginTransaction();
        try {
            $delete = $information->delete();

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
