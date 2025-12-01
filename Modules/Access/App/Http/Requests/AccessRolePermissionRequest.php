<?php

namespace Modules\Access\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccessRolePermissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $roleId = $this->route('role');

        return [
            'name' => [
                'required',
                'string',
                Rule::unique(Role::class, 'name')->where(function ($query) {
                    $query->whereRaw('LOWER(name) = ?', [$this->name]);
                })->ignore($roleId),
            ],
            'permissions' => 'required|array|min:1',
            'permissions.*' => [
                'required',
                'string',
                Rule::exists(Permission::class, 'name'),
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

    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => strtolower($this->name),
            ]);
        }
    }
}
