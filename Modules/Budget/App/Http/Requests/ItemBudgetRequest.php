<?php

namespace Modules\Budget\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemBudgetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'item_budgets' => 'required|array|min:1',
            'item_budgets.*.nominal' => 'required|integer',
            'item_budgets.*.type' => [
                'required',
                Rule::in(array_keys(getItemBudgetTypeList())),
            ],
            'item_budgets.*.note' => 'required|string',
            'item_budgets.*.payment_at' => 'required|date',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
