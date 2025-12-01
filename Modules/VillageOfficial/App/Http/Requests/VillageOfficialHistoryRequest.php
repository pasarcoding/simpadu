<?php

namespace Modules\VillageOfficial\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VillageOfficialHistoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'history' => 'required',
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
