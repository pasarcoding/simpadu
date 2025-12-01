<?php

namespace Modules\Budget\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Budget\Database\factories\ItemBudgetFactory;

class ItemBudget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
