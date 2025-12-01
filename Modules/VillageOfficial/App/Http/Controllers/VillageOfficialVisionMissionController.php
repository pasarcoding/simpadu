<?php

namespace Modules\VillageOfficial\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\VillageOfficial\App\Http\Requests\VillageOfficialVisionMissionRequest;
use Modules\VillageOfficial\App\Http\Services\VillageOfficialVisionMissionService;

class VillageOfficialVisionMissionController extends Controller
{
    protected $villageOfficialVisionMissionService;

    public function __construct(VillageOfficialVisionMissionService $villageOfficialVisionMissionService)
    {
        $this->villageOfficialVisionMissionService = $villageOfficialVisionMissionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->villageOfficialVisionMissionService->get();

        return view('villageofficial::admin.vision_mission.index', [
            'data' => $data,
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $data = $this->villageOfficialVisionMissionService->get();

        return view('villageofficial::admin.vision_mission.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VillageOfficialVisionMissionRequest $request)
    {
        $data = $request->validated();

        try {
            $this->villageOfficialVisionMissionService->update($data);

            return redirect()
                ->route('admin.village-official.vision-mission.index')
                ->with('success', 'Data Visi & Misi berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Visi & Misi:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {
            $this->villageOfficialVisionMissionService->destroy();

            return redirect()
                ->route('admin.village-official.vision-mission.index')
                ->with('success', 'Data Visi & Misi berhasil direset.');
        } catch (Exception $e) {
            Log::error("Reset Hapus Visi & Misi:", ['error' => $e->getMessage()]);

            return back()
                ->with('error', 'Gagal mereset data. Terjadi kesalahan internal.');
        }
    }
}
