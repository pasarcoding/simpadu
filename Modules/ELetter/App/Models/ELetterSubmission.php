<?php

namespace Modules\ELetter\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ELetter\Database\factories\ELetterSubmissionFactory;
use Modules\Resident\App\Models\Resident;

class ELetterSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function e_letter_template()
    {
        return $this->belongsTo(ELetterTemplate::class);
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
