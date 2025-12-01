<?php

namespace Modules\Access\App\Http\Services;

use App\Constants\PermissionName;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AccessRolePermissionService
{
    public function get()
    {
        $query = Role::select(['id', 'name'])
            ->with('permissions')
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('permissions_total', function ($row) {
                return '<span>' . $row->permissions->count() . ' <i>Permission</i></span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::access_role_permission_edit())) {
                    $btn .= '<a href="' . route('admin.access.role-permission.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::access_role_permission_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.access.role-permission.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['permissions_total', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $role = Role::firstOrCreate([
                'name' => $data['name']
            ]);
            $role->syncPermissions($data['permissions']);

            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Role $role, $data)
    {
        DB::beginTransaction();
        try {
            $role->update($data);
            $role->syncPermissions($data['permissions']);

            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $delete = $role->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
