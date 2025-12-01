<?php

namespace Modules\Profile\App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Resident\App\Models\Resident;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
       return [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique(User::class, 'email')->ignore(auth()->user()->id),
            ],
            'password' => 'nullable|string',
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
