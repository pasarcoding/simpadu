<?php

namespace Modules\Resident\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Resident\Database\factories\ResidentFormFactory;

class ResidentForm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function resident_form_value()
    {
        return $this->hasMany(ResidentFormValue::class);
    }
}
