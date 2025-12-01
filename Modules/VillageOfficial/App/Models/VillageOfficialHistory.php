<?php

namespace Modules\VillageOfficial\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\VillageOfficial\Database\factories\VillageOfficialHistoryFactory;

class VillageOfficialHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
}
