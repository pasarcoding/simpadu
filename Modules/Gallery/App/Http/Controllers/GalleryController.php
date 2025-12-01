<?php

namespace Modules\Gallery\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Gallery\App\Http\Requests\GalleryRequest;
use Modules\Gallery\App\Http\Services\GalleryService;
use Modules\Gallery\App\Models\Gallery;

class GalleryController extends Controller
{
    protected $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->galleryService->get();
        }

        return view('gallery::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryRequest $request): RedirectResponse
    {
        $data = $request->validated('gallery');

        try {
            $this->galleryService->store($data);

            return redirect()
                ->route('admin.gallery.index')
                ->with('success', 'Data Gallery berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Gallery:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery): RedirectResponse
    {
        try {
            $this->galleryService->destroy($gallery);

            return redirect()
                ->route('admin.gallery.index')
                ->with('success', 'Data Gallery berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Gallery:", ['error' => $e->getMessage(), 'id' => $gallery->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
