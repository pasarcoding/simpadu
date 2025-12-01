<?php

namespace Modules\Information\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Information\App\Models\Information;
use Modules\Resident\App\Models\Resident;

class InformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $informationId = $this->route('information');
        $isUpdate = $informationId !== null;

        return [
            'title' => 'required|string',
            'status' => 'required|string',
            'thumbnail' => [
                Rule::when(
                    $isUpdate,
                    ['nullable', 'image'],
                    ['required', 'image'],
                ),
            ],
            'content' => 'required|string',
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
