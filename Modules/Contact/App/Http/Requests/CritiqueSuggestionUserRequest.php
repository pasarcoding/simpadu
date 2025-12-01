<?php

namespace Modules\Contact\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CritiqueSuggestionUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
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

    protected function prepareForValidation()
    {
        $phone = $this->phone;

        if (!empty($phone)) {
            $phone = preg_replace('/[^\d+]/', '', $phone);

            if (str_starts_with($phone, '+62')) {
                $phone = '62' . substr($phone, 3);
            }

            elseif (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            $this->merge([
                'phone' => $phone,
            ]);
        }
    }
}
