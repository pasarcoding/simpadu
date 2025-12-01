<?php

namespace Modules\VillageOfficial\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\VillageOfficial\App\Models\VillageOfficialMember;
use Yajra\DataTables\Facades\DataTables;

class VillageOfficialMemberService
{
    public function get()
    {
        $query = VillageOfficialMember::select(['id', 'resident_id', 'position', 'image'])
            ->with('resident')
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                return '<img src="' . $row->image . '" class="rounded-3 object-fit-cover" style="width:4rem; height: 4rem;">';
                // return '<img src="' . $row->resident->image . '" class="rounded-3 object-fit-cover" style="width:4rem; height: 4rem;">';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::village_official_member_edit())) {
                    $btn .= '<a href="' . route('admin.village-official.member.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::village_official_member_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.village-official.member.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        $newImages = [];
        $dataToInsert = [];
        $now = now();

        foreach ($data as $item) {
            $newImage = null;
            if (isset($item['image']) && $item['image']->isValid()) {
                $newImage = $item['image']->store('village_official/member', 'public');
                $newImages[] = $newImage;
            }

            $dataToInsert[] = [
                'resident_id' => $item['resident_id'],
                'position' => $item['position'],
                'image' => $newImage,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::beginTransaction();
        try {
            $villageOfficialMember = VillageOfficialMember::insert($dataToInsert);

            DB::commit();
            return $villageOfficialMember;
        } catch (Exception $e) {
            DB::rollBack();

            foreach ($newImages as $file) {
                Storage::disk('public')->delete($file);
            }

            throw $e;
        }
    }

    public function update(villageOfficialMember $villageOfficialMember, $data)
    {
        $oldImage = $villageOfficialMember->getRawOriginal('image');
        $newImage = null;

        if (isset($data['image']) && $data['image']->isValid()) {
            $newImage = $data['image']->store('village_official/member', 'public');
            $data['image'] = $newImage;
        }

        DB::beginTransaction();
        try {
            $villageOfficialMember->update($data);

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return $villageOfficialMember;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function destroy(VillageOfficialMember $villageOfficialMember)
    {
        $image = $villageOfficialMember->getRawOriginal('image');

        DB::beginTransaction();
        try {
            $delete = $villageOfficialMember->delete();

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
