<?php

namespace Modules\Resident\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResidentFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $residentFormId = $this->route('residentForm');
        $isUpdate = $residentFormId !== null;

        if ($isUpdate) {
            return [
                'name' => 'required|string',
            ];
        }

        return [
            'name' => 'required|array|min:1',
            'name.*' => 'required|string',
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
