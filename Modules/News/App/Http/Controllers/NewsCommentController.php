<?php

namespace Modules\News\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\News\App\Http\Requests\NewsRequest;
use Illuminate\Support\Str;
use Modules\News\App\Http\Services\NewsCommentService;
use Modules\News\App\Models\News;
use Modules\News\App\Models\NewsComment;

class NewsCommentController extends Controller
{
    protected $newsCommentService;

    public function __construct(NewsCommentService $newsCommentService)
    {
        $this->newsCommentService = $newsCommentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(News $news, Request $request)
    {
        if ($request->ajax()) {
            return $this->newsCommentService->get($news);
        }

        return view('news::admin.comment.index', [
            'data' => $news,
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
    public function store(NewsRequest $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news, NewsComment $newsComment): RedirectResponse
    {
        try {
            $this->newsCommentService->destroy($newsComment);

            return redirect()
                ->route('admin.news.comment.index', $news->id)
                ->with('success', 'Data Komentar berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal Hapus Komentar:", ['error' => $e->getMessage(), 'id' => $newsComment->id]);

            return back()
                ->with('error', 'Gagal menghapus data. Terjadi kesalahan internal.');
        }
    }
}
