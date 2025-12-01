<?php

namespace Modules\Appearance\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Appearance\App\Models\AppearanceMenu;
use Whoops\Run;

class AppearanceMenuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists(AppearanceMenu::class, 'id'),
            ],
            'name' => 'required|string',
            'page_origin' => [
                'required',
                'string',
                Rule::in(array_keys(getPageOriginList())),
            ],
            'behaviour_target' => [
                'required',
                'string',
                Rule::in(array_keys(getAppearanceMenuBehaviourTargetList())),
            ],
            'type' => [
                'required',
                'string',
                Rule::in(array_keys(getAppearanceMenuTypeList())),
            ],
            'order' => 'required|integer|min:1',
            'appearance_page_id' => [
                Rule::requiredIf($this->input('page_origin') === 'in'),
                'nullable',
                'string',
            ],
            'url' => [
                Rule::requiredIf($this->input('page_origin') === 'ex'),
                'nullable',
                'string',
                $this->input('page_origin') === 'ex' ? 'url' : '',
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

    protected function prepareForValidation(): void
    {
        if ($this->input('page_origin') === 'in') {
            $this->merge(['url' => null]);
        } elseif ($this->input('page_origin') === 'ex') {
            $this->merge(['appearance_page_id' => null]);
        }
    }
}
