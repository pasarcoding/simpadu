<?php

namespace Modules\Access\App\Http\Services;

use App\Constants\PermissionName;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AccessUserService
{
    public function get()
    {
        $query = User::select(['id', 'name', 'email'])
            ->with('roles')
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('role_name', function ($row) {
                return $row->roles->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::access_user_edit())) {
                    $btn .= '<a href="' . route('admin.access.user.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::access_user_delete()) && $row->id != 1) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.access.user.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($data)
    {
        DB::beginTransaction();
        try {
            $user = User::create($data);
            $user->syncRoles([$data['role']]);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(User $user, $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        DB::beginTransaction();
        try {
            $user->update($data);

            if (isset($data['role'])) {
                $user->syncRoles([$data['role']]);
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $delete = $user->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
