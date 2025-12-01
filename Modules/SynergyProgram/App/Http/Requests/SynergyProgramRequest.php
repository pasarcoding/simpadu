<?php

namespace Modules\SynergyProgram\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SynergyProgramRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'synergy_programs' => 'required|array|min:1',
            'synergy_programs.*.image' => 'required|image',
            'synergy_programs.*.name' => 'required|string'
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
