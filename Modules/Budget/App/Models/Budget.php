<?php

namespace Modules\Budget\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Budget\Database\factories\BudgetFactory;

class Budget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function item_budget()
    {
        return $this->hasMany(ItemBudget::class);
    }
}
