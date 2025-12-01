<?php

namespace Modules\Resident\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Resident\App\Http\Requests\ResidentFormRequest;
use Modules\Resident\App\Http\Services\ResidentFormService;
use Modules\Resident\App\Models\ResidentForm;

class ResidentFormController extends Controller
{
    protected $residentFormService;

    public function __construct(ResidentFormService $residentFormService)
    {
        $this->residentFormService = $residentFormService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->residentFormService->get();
        }

        return view('resident::admin.form.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resident::admin.form.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResidentFormRequest $request): RedirectResponse
    {
        $data = $request->validated('name');

        try {
            $this->residentFormService->store($data);

            return redirect()
                ->route('admin.resident.form.index')
                ->with('success', 'Data Form Tambahan Penduduk berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Form Tambahan Penduduk:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(ResidentForm $residentForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResidentForm $residentForm)
    {
        return view('resident::admin.form.edit', [
            'data' => $residentForm,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResidentFormRequest $request, ResidentForm $residentForm): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->residentFormService->update($residentForm, $data);

            return redirect()
                ->route('admin.resident.form.index')
                ->with('success', 'Data Form Tambahan Penduduk berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Form TambahanPenduduk:", ['error' => $e->getMessage(), 'id' => $residentForm->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResidentForm $residentForm): RedirectResponse
    {
        try {
            $this->residentFormService->destroy($residentForm);

            return redirect()
                ->route('admin.resident.form.index')
                ->with('success', 'Data Form Tambahan Penduduk berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Form Tambahan Penduduk:", ['error' => $e->getMessage(), 'id' => $residentForm->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
