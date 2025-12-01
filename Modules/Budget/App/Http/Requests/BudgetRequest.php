<?php

namespace Modules\Budget\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BudgetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'account_name' => 'required|string',
            'bank_name' => [
                'required',
                Rule::in(array_keys(getBankList())),
            ],
            'bank_number' => 'required|integer',
            'type' => [
                'required',
                Rule::in(array_keys(getBudgetTypeList())),
            ],
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
