<?php

namespace Modules\SynergyProgram\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\SynergyProgram\App\Http\Requests\SynergyProgramRequest;
use Modules\SynergyProgram\App\Http\Services\SynergyProgramService;
use Modules\SynergyProgram\App\Models\SynergyProgram;

class SynergyProgramController extends Controller
{
    protected $synergyProgramService;

    public function __construct(SynergyProgramService $synergyProgramService)
    {
        $this->synergyProgramService = $synergyProgramService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->synergyProgramService->get();
        }

        return view('synergyprogram::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('synergyprogram::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SynergyProgramRequest $request): RedirectResponse
    {
        $data = $request->validated('synergy_programs');

        try {
            $this->synergyProgramService->store($data);

            return redirect()
                ->route('admin.synergy-program.index')
                ->with('success', 'Data Program Sinergi berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Program Sinergi:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(SynergyProgram $synergyProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SynergyProgram $synergyProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SynergyProgramRequest $request, SynergyProgram $synergyProgram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SynergyProgram $synergyProgram): RedirectResponse
    {
        try {
            $this->synergyProgramService->destroy($synergyProgram);

            return redirect()
                ->route('admin.synergy-program.index')
                ->with('success', 'Data Program Sinergi berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Program Sinergi:", ['error' => $e->getMessage(), 'id' => $synergyProgram->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
