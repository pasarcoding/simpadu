<?php

namespace Modules\News\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsCommentUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'content' => 'required|string',
            'website' => 'nullable|url',
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
