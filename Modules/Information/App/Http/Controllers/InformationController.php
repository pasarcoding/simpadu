<?php

namespace Modules\Information\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Console\View\Components\Info;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Information\App\Http\Requests\InformationRequest;
use Modules\Information\App\Http\Services\InformationService;
use Modules\Information\App\Models\Information;
use Illuminate\Support\Str;

class InformationController extends Controller
{
    protected $informationService;

    public function __construct(InformationService $informationService)
    {
        $this->informationService = $informationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->informationService->get();
        }

        return view('information::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('information::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InformationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $data['slug'] = Str::slug($data['title']);

            $this->informationService->store($data);

            return redirect()
                ->route('admin.information.index')
                ->with('success', 'Data Pengumuman berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Pengumuman:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Information $information) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Information $information)
    {
        return view('information::admin.edit', [
            'data' => $information,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InformationRequest $request, Information $information): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->informationService->update($information, $data);

            return redirect()
                ->route('admin.information.index')
                ->with('success', 'Data Pengumuman berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Pengumuman:", ['error' => $e->getMessage(), 'id' => $information->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information): RedirectResponse
    {
        try {
            $this->informationService->destroy($information);

            return redirect()
                ->route('admin.information.index')
                ->with('success', 'Data Pengumuman berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Pengumuman:", ['error' => $e->getMessage(), 'id' => $information->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
