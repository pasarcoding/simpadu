<?php

namespace Modules\Resident\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Resident\App\Models\Resident;

class ResidentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $residentId = $this->route('resident');

        return [
            'national_id' => [
                'required',
                'string',
                'digits:16',
                Rule::unique(Resident::class, 'national_id')->ignore($residentId),
            ],
            'full_name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'death_status' => [
                'required',
                Rule::in(array_keys(getDeathStatusList())),
            ],
            'gender' => [
                'required',
                Rule::in(array_keys(getGenderList())),
            ],
            'citizenship' => [
                'required',
                Rule::in(array_keys(getCitizenshipList())),
            ],
            'religion' => [
                'required',
                Rule::in(array_keys(getReligionList())),
            ],
            'job' => [
                'required',
                Rule::in(array_keys(getJobList())),
            ],
            'other_job' => 'nullable|string',
            'last_education' => [
                'required',
                Rule::in(array_keys(getEducationList())),
            ],
            'marital_status' => [
                'required',
                Rule::in(array_keys(getMaritalStatusList())),
            ],
            'family_relationship' => [
                'required',
                Rule::in(array_keys(getFamilyRelationshipList())),
            ],
            'family_card_number' => 'required|digits:16',
            'hamlet_village' => 'nullable',
            'transfer_date' => 'nullable|date',
            'image' => 'nullable|image',
            'resident_forms' => 'nullable|array|min:1',
            'resident_forms.*' => 'nullable|string',
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
