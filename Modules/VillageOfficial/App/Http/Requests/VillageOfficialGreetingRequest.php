<?php

namespace Modules\VillageOfficial\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\VillageOfficial\App\Models\VillageOfficialGreeting;

class VillageOfficialGreetingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        $isGreetingExists = VillageOfficialGreeting::exists();

        return [
            'name' => 'required',
            'image' => [
                Rule::when(
                    $isGreetingExists,
                    ['nullable', 'image'],
                    ['required', 'image'],
                ),
            ],
            'sign_image' => [
                Rule::when(
                    $isGreetingExists,
                    ['nullable', 'image'],
                    ['required', 'image'],
                ),
            ],
            'content' => 'required',
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
