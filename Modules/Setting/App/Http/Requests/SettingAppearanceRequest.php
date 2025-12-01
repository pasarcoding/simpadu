<?php

namespace Modules\Setting\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingAppearanceRequest extends FormRequest
{
    protected $errorBag = 'appearance';

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'background_banner' => 'nullable|image',
            'color_primary' => 'required|string',
            'color_secondary' => 'required|string',
            'color_accent' => 'required|string',
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
