<?php

namespace Modules\ELetter\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\ELetter\App\Models\ELetterTemplate;

class ELetterSubmissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'status' => [
                'required',
                Rule::in(array_keys(getSubmissionStatusList())),
            ]
        ];

        return array_merge($rules, $this->getDynamicFormRules());
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function getDynamicFormRules()
    {
        $eLetterSubmission = $this->route('eLetterSubmission');

        $template = ELetterTemplate::find($eLetterSubmission->e_letter_template_id);
        $listVariables = json_decode($template->list_variables, true);

        $dynamicRules = [];
        foreach ($listVariables as $item) {
            $name = data_get($item, 'name');
            $format = data_get($item, 'format');

            $rules = [];
            switch ($format) {
                case 'text':
                    $rules[] = 'required';
                    $rules[] = 'string';
                    break;
                case 'image':
                    $rules[] = 'nullable';
                    $rules[] = 'file';
                    $rules[] = 'mimes:jpeg,png,jpg,gif,svg';
                    break;
            }

            $dynamicRules['form.' . $name] = $rules;
        }

        return $dynamicRules;
    }
}
