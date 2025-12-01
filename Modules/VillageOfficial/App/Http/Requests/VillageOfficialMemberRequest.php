<?php

namespace Modules\VillageOfficial\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Resident\App\Models\Resident;

class VillageOfficialMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $memberId = $this->route('villageOfficialMember');
        $isUpdate = $memberId !== null;

        if ($isUpdate) {
            return [
                'resident_id' => [
                    'required',
                    'integer',
                    Rule::exists(Resident::class, 'id'),
                ],
                'position' => 'required|string',
                'image' => 'nullable|image',
            ];
        }

        return [
            'members' => 'required|array|min:1',
            'members.*.resident_id' => ['required', 'integer', 'exists:residents,id'],
            'members.*.position' => 'required|string',
            'members.*.image' => 'required|image',
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
