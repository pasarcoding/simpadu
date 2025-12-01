<?php

namespace Modules\Product\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $productId = $this->route('product');
        $isUpdate = $productId !== null;

        return [
            'name' => 'required|string',
            'price' => 'required|integer',
            'whatsapp_number' => 'required|string',
            'image' => [
                Rule::when(
                    $isUpdate,
                    ['nullable', 'image'],
                    ['required', 'image'],
                ),
            ],
            'description' => 'required|string',
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
}
