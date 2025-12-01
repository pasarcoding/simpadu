<?php

namespace Modules\Appearance\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppearancePage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function appearance_menu()
    {
        return $this->hasMany(AppearanceMenu::class);
    }
}
