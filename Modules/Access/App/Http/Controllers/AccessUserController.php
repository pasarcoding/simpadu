<?php

namespace Modules\Access\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Access\App\Http\Requests\AccessUserRequest;
use Modules\Access\App\Http\Services\AccessUserService;
use Spatie\Permission\Models\Role;

class AccessUserController extends Controller
{
    protected $accessUserService;

    public function __construct(AccessUserService $accessUserService)
    {
        $this->accessUserService = $accessUserService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->accessUserService->get();
        }

        return view('access::admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select(['id', 'name'])
            ->whereNot('name', 'admin')
            ->get();

        return view('access::admin.user.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccessUserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->accessUserService->store($data);

            return redirect()
                ->route('admin.access.user.index')
                ->with('success', 'Data Pengguna berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Pengguna:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(User $user) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::select(['id', 'name'])
            ->whereNot('name', 'admin')
            ->get();

        return view('access::admin.user.edit', [
            'data' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccessUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->accessUserService->update($user, $data);

            return redirect()
                ->route('admin.access.user.index')
                ->with('success', 'Data Pengguna berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Pengguna:", ['error' => $e->getMessage(), 'id' => $user->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->accessUserService->destroy($user);

            return redirect()
                ->route('admin.access.user.index')
                ->with('success', 'Data Pengguna berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Pengguna:", ['error' => $e->getMessage(), 'id' => $user->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
