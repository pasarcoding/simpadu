<?php

namespace Modules\VillageOfficial\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\VillageOfficial\App\Http\Requests\VillageOfficialHistoryRequest;
use Modules\VillageOfficial\App\Http\Services\VillageOfficialHistoryService;

class VillageOfficialHistoryController extends Controller
{
    protected $villageOfficialHistoryService;

    public function __construct(VillageOfficialHistoryService $villageOfficialHistoryService)
    {
        $this->villageOfficialHistoryService = $villageOfficialHistoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->villageOfficialHistoryService->get();

        return view('villageofficial::admin.history.index', [
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
        $data = $this->villageOfficialHistoryService->get();

        return view('villageofficial::admin.history.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VillageOfficialHistoryRequest $request)
    {
        $data = $request->validated();

        try {
            $this->villageOfficialHistoryService->update($data);

            return redirect()
                ->route('admin.village-official.history.index')
                ->with('success', 'Data Sejarah berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Sejarah:", ['error' => $e->getMessage()]);

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
            $this->villageOfficialHistoryService->destroy();

            return redirect()
                ->route('admin.village-official.history.index')
                ->with('success', 'Data Sejarah berhasil direset.');
        } catch (Exception $e) {
            Log::error("Reset Hapus Sejarah:", ['error' => $e->getMessage()]);

            return back()
                ->with('error', 'Gagal mereset data. Terjadi kesalahan internal.');
        }
    }
}
