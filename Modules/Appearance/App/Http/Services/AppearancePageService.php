<?php

namespace Modules\Appearance\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Appearance\App\Models\AppearancePage;
use Yajra\DataTables\Facades\DataTables;

class AppearancePageService
{
    public function get()
    {
        $query = AppearancePage::select(['id', 'title', 'slug', 'content'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('url', function ($row) {
                return 'page/' . $row->slug;
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('user.appearance.page.index', $row->slug). '" target="_blank" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-eye"></i></a>';

                if (auth()->user()->can(PermissionName::appearance_page_edit())) {
                    $btn .= ' <a href="' . route('admin.appearance.page.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::appearance_page_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.appearance.page.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['url', 'action'])
            ->make(true);
    }

    public function store($data)
    {

        DB::beginTransaction();
        try {
            $appearancePage = AppearancePage::create($data);

            DB::commit();
            return $appearancePage;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(AppearancePage $appearancePage, $data)
    {
        DB::beginTransaction();
        try {
            $appearancePage->update($data);

            DB::commit();
            return $appearancePage;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(AppearancePage $appearancePage)
    {
        DB::beginTransaction();
        try {
            $delete = $appearancePage->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
