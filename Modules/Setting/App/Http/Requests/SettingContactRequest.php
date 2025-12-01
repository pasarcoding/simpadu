<?php

namespace Modules\Setting\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingContactRequest extends FormRequest
{
    protected $errorBag = 'contact';

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'maps' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'whatsapp' => 'nullable|string',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
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
        $phone = $this->whatsapp;

        if (!empty($phone)) {
            $phone = preg_replace('/[^\d+]/', '', $phone);

            if (str_starts_with($phone, '+62')) {
                $phone = '62' . substr($phone, 3);
            }

            elseif (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }

            $this->merge([
                'whatsapp' => $phone,
            ]);
        }
    }
}
