<?php

namespace Modules\News\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\News\App\Models\News;
use Yajra\DataTables\Facades\DataTables;

class NewsService
{
    public function get()
    {
        $query = News::select(['id', 'title', 'slug', 'status', 'views', 'thumbnail', 'user_id'])
            ->with(['user', 'news_comment'])
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('views', function ($row) {
                return $row->views . 'x Dilihat';
            })
            ->addColumn('comments', function ($row) {
                $text = $row->news_comment->count() . ' Komentar';
                return '<a href="' . route('admin.news.comment.index', $row->id) . '">' . $text . '</a>';
            })
            ->editColumn('thumbnail', function ($row) {
                return '<img src="' . $row->thumbnail . '" class="rounded-3 object-fit-cover" style="width:6rem; height: 4rem;">';
            })
            ->editColumn('status', function ($row) {
                $statusBg = [
                    'publish' => 'bg-success',
                    'arsip' => 'bg-danger'
                ];

                return '<span class="badge ' . $statusBg[$row->status] . '">' . getPusblishStatusList()[$row->status] . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('user.news.detail', $row->slug). '" target="_blank" class="btn btn-sm btn-success" title="Detail"><i class="ti ti-eye"></i></a>';

                if (auth()->user()->can(PermissionName::news_edit())) {
                    $btn .= ' <a href="' . route('admin.news.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit"><i class="ti ti-edit"></i></a>';
                }

                if (auth()->user()->can(PermissionName::news_delete())) {
                    $btn .= ' <button class="btn btn-sm btn-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-url="' . route('admin.news.delete', $row->id) . '"><i class="ti ti-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['url', 'thumbnail', 'status', 'comments', 'action'])
            ->make(true);
    }

    public function store($data)
    {
        $newImage = null;
        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            $newImage = $data['thumbnail']->store('news', 'public');
            $data['thumbnail'] = $newImage;
        }

        $data['user_id'] = auth()->user()->id;

        DB::beginTransaction();
        try {
            $news = News::create($data);

            DB::commit();
            return $news;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function update(News $news, $data)
    {
        $oldImage = $news->getRawOriginal('thumbnail');
        $newImage = null;

        if (isset($data['thumbnail']) && $data['thumbnail']->isValid()) {
            $newImage = $data['thumbnail']->store('news', 'public');
            $data['thumbnail'] = $newImage;
        }

        DB::beginTransaction();
        try {
            $news->update($data);

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return $news;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function destroy(News $news)
    {
        $image = $news->getRawOriginal('thumbnail');

        DB::beginTransaction();
        try {
            $delete = $news->delete();

            if ($delete && $image) {
                Storage::disk('public')->delete($image);
            }

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
