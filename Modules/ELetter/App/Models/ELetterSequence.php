<?php

namespace Modules\ELetter\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ELetter\Database\factories\ELetterSequenceFactory;

class ELetterSequence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected $primaryKey = 'date';

    public $timestamps = false;
}
