<?php

namespace Modules\VillageOfficial\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Modules\VillageOfficial\Database\factories\VillageOfficialGreetingFactory;

class VillageOfficialGreeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function getImageAttribute($data)
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return Storage::url($data);
        }

        return asset('images/default-placeholder.jpg');
    }

    public function getSignImageAttribute($data)
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return Storage::url($data);
        }

        return asset('images/default-placeholder.jpg');
    }
}
