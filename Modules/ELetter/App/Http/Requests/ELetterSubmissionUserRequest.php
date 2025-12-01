<?php

namespace Modules\ELetter\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\ELetter\App\Models\ELetterTemplate;

class ELetterSubmissionUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'e_letter_template_id' => ['required', Rule::exists(ELetterTemplate::class, 'id')],
            'whatsapp_number' => 'required|string',
            'national_id' => 'required|string',
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

    protected function prepareForValidation()
    {
        $phone = $this->whatsapp_number;

        if (!empty($phone)) {
            $phone = preg_replace('/[^\d+]/', '', $phone);

            if (str_starts_with($phone, '+62')) {
                $phone = '62' . substr($phone, 3);
            }

            elseif (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            $this->merge([
                'whatsapp_number' => $phone,
            ]);
        }
    }

    protected function getDynamicFormRules()
    {
        $templateId = $this->input('e_letter_template_id');

        $template = EletterTemplate::find($templateId);
        $listVariables = json_decode($template->list_variables, true);

        $dynamicRules = [];
        foreach ($listVariables as $item) {
            $name = data_get($item, 'name');
            $format = data_get($item, 'format');

            $rules = ['required'];
            switch ($format) {
                case 'text':
                    $rules[] = 'string';
                    break;
                case 'image':
                    $rules[] = 'file';
                    $rules[] = 'mimes:jpeg,png,jpg,gif,svg';
                    break;
            }

            $dynamicRules['form.' . $name] = $rules;
        }

        return $dynamicRules;
    }
}
