<?php

namespace Modules\Setting\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingELetterRequest extends FormRequest
{
    protected $errorBag = 'e_letter';

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'success' => 'required|string',
            'reject' => 'required|string',
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
