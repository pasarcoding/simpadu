<?php

namespace Modules\Resident\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Modules\VillageOfficial\App\Models\VillageOfficialMember;

class Resident extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function village_official_member()
    {
        return $this->hasMany(VillageOfficialMember::class);
    }

    public function resident_form_value()
    {
        return $this->hasMany(ResidentFormValue::class);
    }

    public function getImageAttribute($data)
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return Storage::url($data);
        }

        return asset('images/default-placeholder.jpg');
    }
}
