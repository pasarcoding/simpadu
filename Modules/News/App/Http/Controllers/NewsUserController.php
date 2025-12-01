<?php

namespace Modules\News\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\News\App\Http\Requests\NewsCommentUserRequest;
use Modules\News\App\Http\Services\NewsUserService;
use Modules\News\App\Models\News;

class NewsUserController extends Controller
{
    protected $newsUserService;

    public function __construct(NewsUserService $newsUserService)
    {
        $this->newsUserService = $newsUserService;
    }

    public function index(Request $request)
    {
        $searchQuery = $request->query('s');

        $news = News::with('user');

        if($searchQuery){
            $news->where('title', 'LIKE', '%' . $searchQuery . '%');
        }

        $news = $news->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('news::user.index', [
            'news' => $news,
            'searchQuery' => $searchQuery,
        ]);
    }

    public function show(News $news)
    {
        $sessionId = Session::getId();
        $viewKey = 'news_' . $news->id . '_viewed_by_' . $sessionId;

        if(!Session::has($viewKey)){
            $news->increment('views');
            Session::put($viewKey, true);
        }

        return view('news::user.detail', [
            'data' => $news,
        ]);
    }

    public function comment(NewsCommentUserRequest $request, News $news)
    {
        $data = $request->validated();

        try {
            $this->newsUserService->comment($news, $data);

            return redirect()
                ->route('user.news.detail', $news->slug)
                ->with('success', 'Komentar berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal Store Komentar:", ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Penyimpanan data gagal. Terjadi kesalahan internal.');
        }
    }
}
