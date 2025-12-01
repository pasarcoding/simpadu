<?php

namespace Modules\VillageOfficial\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\VillageOfficial\Database\factories\VillageOfficialVisionMissionFactory;

class VillageOfficialVisionMission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
}
