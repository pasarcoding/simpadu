<?php

namespace Modules\Appearance\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Appearance\App\Http\Requests\AppearancePageRequest;
use Modules\Appearance\App\Http\Services\AppearancePageService;
use Modules\Appearance\App\Models\AppearancePage;

class AppearancePageController extends Controller
{
    protected $appearancePageService;

    public function __construct(AppearancePageService $appearancePageService)
    {
        $this->appearancePageService = $appearancePageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->appearancePageService->get();
        }

        return view('appearance::admin.page.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appearance::admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppearancePageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $data['slug'] = Str::slug($data['title']);

            $this->appearancePageService->store($data);

            return redirect()
                ->route('admin.appearance.page.index')
                ->with('success', 'Data Halaman berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Halaman:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(AppearancePage $appearancePage) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppearancePage $appearancePage)
    {
        return view('appearance::admin.page.edit', [
            'data' => $appearancePage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AppearancePageRequest $request, AppearancePage $appearancePage): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->appearancePageService->update($appearancePage, $data);

            return redirect()
                ->route('admin.appearance.page.index')
                ->with('success', 'Data Halaman berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Halaman:", ['error' => $e->getMessage(), 'id' => $appearancePage->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AppearancePage $appearancePage): RedirectResponse
    {
        try {
            $this->appearancePageService->destroy($appearancePage);

            return redirect()
                ->route('admin.appearance.page.index')
                ->with('success', 'Data Halaman berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Halaman:", ['error' => $e->getMessage(), 'id' => $appearancePage->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
