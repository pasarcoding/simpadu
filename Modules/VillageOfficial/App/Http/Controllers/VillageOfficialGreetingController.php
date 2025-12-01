<?php

namespace Modules\VillageOfficial\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\VillageOfficial\App\Http\Services\VillageOfficialGreetingService;
use Modules\VillageOfficial\App\Http\Requests\VillageOfficialGreetingRequest;

class VillageOfficialGreetingController extends Controller
{
    protected $villageOfficialGreetingService;

    public function __construct(VillageOfficialGreetingService $villageOfficialGreetingService)
    {
        $this->villageOfficialGreetingService = $villageOfficialGreetingService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->villageOfficialGreetingService->get();

        return view('villageofficial::admin.greeting.index', [
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
        $data = $this->villageOfficialGreetingService->get();

        return view('villageofficial::admin.greeting.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VillageOfficialGreetingRequest $request)
    {
        $data = $request->validated();

        try {
            $this->villageOfficialGreetingService->update($data);

            return redirect()
                ->route('admin.village-official.greeting.index')
                ->with('success', 'Data Sambutan berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Sambutan:", ['error' => $e->getMessage()]);

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
            $this->villageOfficialGreetingService->destroy();

            return redirect()
                ->route('admin.village-official.greeting.index')
                ->with('success', 'Data Sambutan berhasil direset.');
        } catch (Exception $e) {
            Log::error("Reset Hapus Sambutan:", ['error' => $e->getMessage()]);

            return back()
                ->with('error', 'Gagal mereset data. Terjadi kesalahan internal.');
        }
    }
}
