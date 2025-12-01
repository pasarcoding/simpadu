<?php

namespace Modules\Access\App\Http\Controllers;

use App\Constants\PermissionName;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Access\App\Http\Requests\AccessRolePermissionRequest;
use Modules\Access\App\Http\Services\AccessRolePermissionService;
use Spatie\Permission\Models\Role;

class AccessRolePermissionController extends Controller
{
    protected $accessRolePermissionService;

    public function __construct(AccessRolePermissionService $accessRolePermissionService)
    {
        $this->accessRolePermissionService = $accessRolePermissionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->accessRolePermissionService->get();
        }

        return view('access::admin.role_permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = PermissionName::getGroupModule();

        return view('access::admin.role_permission.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccessRolePermissionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->accessRolePermissionService->store($data);

            return redirect()
                ->route('admin.access.role-permission.index')
                ->with('success', 'Data Peran & Hak Akses berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Peran & Hak Akses:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Role $role) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role->load('permissions');

        $permissions = PermissionName::getGroupModule();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('access::admin.role_permission.edit', [
            'data' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccessRolePermissionRequest $request, Role $role): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->accessRolePermissionService->update($role, $data);

            return redirect()
                ->route('admin.access.role-permission.index')
                ->with('success', 'Data Peran & Hak Akses berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Peran & Hak Akses:", ['error' => $e->getMessage(), 'id' => $role->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        try {
            $this->accessRolePermissionService->destroy($role);

            return redirect()
                ->route('admin.access.role-permission.index')
                ->with('success', 'Data Peran & Hak Akses berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Peran & Hak Akses:", ['error' => $e->getMessage(), 'id' => $role->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
