<?php

namespace Modules\News\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\News\App\Http\Services\NewsService;
use Modules\News\App\Http\Requests\NewsRequest;
use Illuminate\Support\Str;
use Modules\News\App\Models\News;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->newsService->get();
        }

        return view('news::admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news::admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $data['slug'] = Str::slug($data['title']);

            $this->newsService->store($data);

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Data Berita berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Berita:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show(News $news) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news::admin.news.edit', [
            'data' => $news,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->validated();

        try {
            $this->newsService->update($news, $data);

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Data Berita berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal Update Berita:", ['error' => $e->getMessage(), 'id' => $news->id]);

            return back()
                ->withInput()
                ->with('error', 'Pembaruan data gagal. Terjadi kesalahan internal.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news): RedirectResponse
    {
        try {
            $this->newsService->destroy($news);

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'Data Berita berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Berita:", ['error' => $e->getMessage(), 'id' => $news->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
