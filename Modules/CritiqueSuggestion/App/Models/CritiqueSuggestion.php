<?php

namespace Modules\CritiqueSuggestion\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CritiqueSuggestion\Database\factories\CritiqueSuggestionFactory;

class CritiqueSuggestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
}
