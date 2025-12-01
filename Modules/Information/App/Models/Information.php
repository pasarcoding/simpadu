<?php

namespace Modules\Information\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Modules\Information\Database\factories\InformationFactory;

class Information extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'informations';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getThumbnailAttribute($data)
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return Storage::url($data);
        }

        return asset('images/default-placeholder.jpg');
    }
}
