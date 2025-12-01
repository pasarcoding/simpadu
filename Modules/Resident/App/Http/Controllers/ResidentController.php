<?php

namespace Modules\Resident\App\Http\Controllers;

use App\Exports\ResidentTemplateExport;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Resident\App\Http\Requests\ResidentImportRequest;
use Modules\Resident\App\Http\Requests\ResidentRequest;
use Modules\Resident\App\Http\Services\ResidentService;
use Modules\Resident\App\Models\Resident;
use Modules\Resident\App\Models\ResidentForm;

class ResidentController extends Controller
{
    protected $residentService;

    public function __construct(ResidentService $residentService)
    {
        $this->residentService = $residentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->residentService->get($request);
        }

        $villages = Resident::select(DB::raw('LOWER(hamlet_village) as normalized_village'))
            ->distinct()
            ->pluck('normalized_village')
            ->filter()
            ->values();
        $villageQuery = $request->input('village');
        $ageQuery = $request->input('age');

        return view('resident::admin.index', [
            'villages' => $villages,
            'villageQuery' => $villageQuery,
            'ageQuery' => $ageQuery,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $forms = ResidentForm::select('id', 'name')->get();

        return view('resident::admin.create', [
            'forms' => $forms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResidentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->residentService->store($data);

            return redirect()
                ->route('admin.resident.index')
                ->with('success', 'Data Penduduk berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Penduduk:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    public function import()
    {
        return view('resident::admin.import');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_import(ResidentImportRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->residentService->import($data);

            return redirect()
                ->route('admin.resident.index')
                ->with('success', 'Data Penduduk berhasil diimport.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Gagal Import Penduduk:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Pengimport data gagal. Terjadi kesalahan internal.');
        }
    }

    public function export(Request $request)
    {
        try {
            return $this->residentService->export($request);
        } catch (Exception $e) {
            Log::error("Gagal Export Penduduk:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Export data gagal. Terjadi kesalahan internal.');
        }
    }

    public function export_template()
    {
        try {
            return $this->residentService->export_template();
        } catch (Exception $e) {
            Log::error("Gagal Export Template Penduduk:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Export template gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Resident $resident)
    {
        $resident->load(['resident_form_value', 'resident_form_value.resident_form']);

        return view('resident::admin.show', [
            'data' => $resident,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        $resident->load('resident_form_value');

        $forms = ResidentForm::select('id', 'name')->get();
        $formValue = $resident->resident_form_value->keyBy('resident_form_id');

        return view('resident::admin.edit', [
            'data' => $resident,
            'forms' => $forms,
            'formValue' => $formValue,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResidentRequest $request, Resident $resident): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->residentService->update($resident, $data);

            return redirect()
                ->route('admin.resident.index')
                ->with('success', 'Data Penduduk berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Penduduk:", ['error' => $e->getMessage(), 'id' => $resident->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident): RedirectResponse
    {
        try {
            $this->residentService->destroy($resident);

            return redirect()
                ->route('admin.resident.index')
                ->with('success', 'Data Penduduk berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Penduduk:", ['error' => $e->getMessage(), 'id' => $resident->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }

    public function reset(): RedirectResponse
    {
        try {
            $this->residentService->reset();

            return redirect()
                ->route('admin.resident.index')
                ->with('success', 'Data Penduduk berhasil direset.');
        } catch (Exception $e) {
            Log::error("Gagal Reset Penduduk:", ['error' => $e->getMessage()]);

            return back()
                ->with('error', 'Gagal mereset data. Terjadi kesalahan internal.');
        }
    }
}
