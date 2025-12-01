<?php

namespace Modules\Setting\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingAppRequest extends FormRequest
{
    protected $errorBag = 'app';

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'logo' => 'nullable|image',
            'description' => 'required|string',
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
