<?php

namespace Modules\Gallery\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Gallery\App\Models\Gallery;
use Yajra\DataTables\Facades\DataTables;

class GalleryService
{
    public function get()
    {
        $query = Gallery::select(['id', 'title', 'image'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" class="rounded-3 object-fit-cover" style="width: 4rem; height: 4rem;">';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::gallery_delete())) {
                    return '<button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.gallery.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
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
                $newImage = $item['image']->store('gallery', 'public');
                $item['image'] = $newImage;
                $newImageList[] = $newImage;
            }

            $dataToInsert[] = [
                'image' => $item['image'],
                'title' => $item['title'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::beginTransaction();
        try {
            $gallery = Gallery::insert($dataToInsert);

            DB::commit();
            return $gallery;
        } catch (Exception $e) {
            DB::rollBack();

            if (!empty($newImageList)) {
                Storage::disk('public')->delete($newImageList);
            }

            throw $e;
        }
    }

    public function destroy(Gallery $gallery)
    {
        $image = $gallery->getRawOriginal('image');

        DB::beginTransaction();
        try {
            $delete = $gallery->delete();

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
