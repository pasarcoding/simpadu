<?php

namespace Modules\News\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $newsId = $this->route('news');
        $isUpdate = $newsId !== null;

        return [
            'title' => 'required|string',
            'status' => 'required|string',
            'thumbnail' => [
                Rule::when(
                    $isUpdate,
                    ['nullable', 'image'],
                    ['required', 'image'],
                ),
            ],
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
}
