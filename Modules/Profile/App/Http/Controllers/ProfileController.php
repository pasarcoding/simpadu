<?php

namespace Modules\Profile\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Profile\App\Http\Requests\ProfileRequest;
use Modules\Profile\App\Http\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileRequest $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('profile::admin.edit', [
            'data' => auth()->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->profileService->update(auth()->user(), $data);

            return redirect()
                ->route('admin.profile.edit')
                ->with('success', 'Data Profile berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Profile:", ['error' => $e->getMessage(), 'id' => auth()->user()->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
