<?php

namespace Modules\Resident\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Resident\Database\factories\ResidentFormValueFactory;

class ResidentFormValue extends Model
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

    public function resident_form()
    {
        return $this->belongsTo(ResidentForm::class);
    }
}
