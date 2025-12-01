<?php

namespace Modules\News\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\News\Database\factories\NewsCommentFactory;

class NewsComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
