<?php

namespace Modules\VillageOfficial\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Modules\Resident\App\Models\Resident;
use Modules\VillageOfficial\Database\factories\VillageOfficialMemberFactory;

class VillageOfficialMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function getImageAttribute($data)
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return Storage::url($data);
        }

        return asset('images/default-placeholder.jpg');
    }
}
