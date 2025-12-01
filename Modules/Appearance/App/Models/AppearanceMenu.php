<?php

namespace Modules\Appearance\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppearanceMenu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(AppearanceMenu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AppearanceMenu::class, 'parent_id');
    }

    public function appearance_page()
    {
        return $this->belongsTo(AppearancePage::class);
    }
}
