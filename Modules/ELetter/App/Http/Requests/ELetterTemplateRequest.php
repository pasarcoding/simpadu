<?php

namespace Modules\ELetter\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ELetterTemplateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $templateId = $this->route('eLetterTemplate');
        $isUpdate = $templateId !== null;

        return [
            'name' => 'required|string',
            'last_sequence_number' => 'required|string',
            'file' => [
                Rule::when(
                    $isUpdate,
                    ['nullable', 'file', 'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword'],
                    ['required', 'file', 'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword'],
                ),
            ],
            'status' => [
                'required',
                Rule::in(array_keys(getTemplateStatusList()))
            ]
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'file.mimetypes' => 'The :attribute must be a valid Microsoft Word document (.docx or .doc).'
        ];
    }
}
