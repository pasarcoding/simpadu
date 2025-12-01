<?php

namespace Modules\SynergyProgram\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Modules\SynergyProgram\Database\factories\SynergyProgramFactory;

class SynergyProgram extends Model
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
}
