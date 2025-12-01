<?php

namespace Modules\Access\App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AccessUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        $isUpdate = $userId !== null;

        return [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique(User::class, 'email')->ignore($userId),
            ],
            'password' => [
                Rule::when(
                    $isUpdate,
                    ['nullable', 'string'],
                    ['required', 'string'],
                ),
            ],
            'role' => [
                Rule::when(
                    $isUpdate && $userId->id == 1,
                    [
                        'nullable',
                        Rule::exists(Role::class, 'name'),
                    ],
                    [
                        'required',
                        Rule::exists(Role::class, 'name'),
                    ]
                )
            ],
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
