<?php

namespace Modules\VillageOfficial\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Resident\App\Models\Resident;
use Modules\VillageOfficial\App\Http\Requests\VillageOfficialMemberRequest;
use Modules\VillageOfficial\App\Http\Services\VillageOfficialMemberService;
use Modules\VillageOfficial\App\Models\VillageOfficialMember;

class VillageOfficialMemberController extends Controller
{
    protected $villageOfficialMemberService;

    public function __construct(VillageOfficialMemberService $villageOfficialMemberService)
    {
        $this->villageOfficialMemberService = $villageOfficialMemberService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->villageOfficialMemberService->get();
        }

        return view('villageofficial::admin.member.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $residents = Resident::select(['id', 'full_name', 'national_id', 'hamlet_village', 'rt', 'rw'])->get();

        return view('villageofficial::admin.member.create', [
            'residents' => $residents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VillageOfficialMemberRequest $request): RedirectResponse
    {
        $data = $request->validated('members');

        try {
            $this->villageOfficialMemberService->store($data);

            return redirect()
                ->route('admin.village-official.member.index')
                ->with('success', 'Data Anggota berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Anggota:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(VillageOfficialMember $villageOfficialMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VillageOfficialMember $villageOfficialMember)
    {
        $residents = Resident::select(['id', 'full_name', 'national_id', 'hamlet_village', 'rt', 'rw'])->get();

        return view('villageofficial::admin.member.edit', [
            'residents' => $residents,
            'data' => $villageOfficialMember,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VillageOfficialMemberRequest $request, VillageOfficialMember $villageOfficialMember): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->villageOfficialMemberService->update($villageOfficialMember, $data);

            return redirect()
                ->route('admin.village-official.member.index')
                ->with('success', 'Data Anggota berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Anggota:", ['error' => $e->getMessage(), 'id' => $villageOfficialMember->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VillageOfficialMember $villageOfficialMember): RedirectResponse
    {
        try {
            $this->villageOfficialMemberService->destroy($villageOfficialMember);

            return redirect()
                ->route('admin.village-official.member.index')
                ->with('success', 'Data Anggota berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Anggota:", ['error' => $e->getMessage(), 'id' => $villageOfficialMember->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
