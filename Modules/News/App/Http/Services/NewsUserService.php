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

class NewsUserService
{

    public function comment(News $news, $data)
    {

        DB::beginTransaction();
        try {
            $data['news_id'] = $news->id;
            $newsComment = NewsComment::create($data);

            DB::commit();
            return $newsComment;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
