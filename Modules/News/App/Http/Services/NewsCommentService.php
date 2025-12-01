<?php

namespace Modules\News\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\News\App\Models\News;
use Modules\News\App\Models\NewsComment;
use Yajra\DataTables\Facades\DataTables;

class NewsCommentService
{
    public function get(News $news)
    {
        $query = NewsComment::select(['id', 'news_id', 'name', 'email', 'website', 'content'])
            ->with(['news'])
            ->where('news_id', $news->id)
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('comment', function ($row) {
                return '<div class="d-flex flex-column">'
                    . '<div>Nama: <b>' . $row->name . '</b></div>'
                    . '<div>Email: <b>' . $row->email . '</b></div>'
                    . ($row->website ? '<div>Website: <a href="' . $row->name . '" target="_blank">' . $row->website . '</a></div>' : '')
                    . '<div class="mt-2">' . $row->content . '</div>'
                    . '</div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '';

                if (auth()->user()->can(PermissionName::news_comment_delete())) {
                    $btn .= '<button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.news.comment.delete', ['news' => $row->news_id, 'newsComment' => $row->id]) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['comment', 'action'])
            ->make(true);
    }

    public function destroy(NewsComment $newComment)
    {
        DB::beginTransaction();
        try {
            $delete = $newComment->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
