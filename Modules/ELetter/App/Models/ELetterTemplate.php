<?php

namespace Modules\ELetter\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Modules\ELetter\Database\factories\ELetterTemplateFactory;

class ELetterTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function getFileAttribute($data)
    {
        if ($data && Storage::disk('public')->exists($data)) {
            return Storage::url($data);
        }

        return '';
    }
}
