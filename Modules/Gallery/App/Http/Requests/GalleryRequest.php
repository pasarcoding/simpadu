<?php

namespace Modules\Gallery\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'gallery' => 'required|array|min:1',
            'gallery.*.image' => 'required|image',
            'gallery.*.title' => 'required|string'
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
