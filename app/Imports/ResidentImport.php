<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Modules\Resident\App\Models\Resident;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Modules\Resident\App\Models\ResidentForm;

class ResidentImport implements ToCollection, WithHeadingRow, WithValidation, WithStartRow, SkipsOnFailure
{
    private $failures;
    protected $rows;
    protected $dynamicFormMapping = [];

    public function __construct()
    {
        HeadingRowFormatter::default('none');
        $this->failures = new Collection();
        $this->rows = new Collection();

        $this->dynamicFormMapping = ResidentForm::pluck('id', 'name')->toArray();
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function collection(Collection $collection)
    {
        $this->rows = $collection->filter(function ($row) {
            $nik = trim($row['NIK*'] ?? '');
            return !empty($nik);
        });
    }

    public function getRows(): Collection
    {
        return $this->rows;
    }

    public function getDynamicFormMapping()
    {
        return $this->dynamicFormMapping;
    }

    // public function model(array $row)
    // {
    //     $nik = trim($row['NIK*'] ?? '');

    //     // if (empty($nik)) continue;

    //     if (empty($nik)) {
    //         return null;
    //     }

    //     $tanggalLahir = null;
    //     if (isset($row['Tanggal Lahir*']) && is_numeric($row['Tanggal Lahir*'])) {
    //         try {
    //             $tanggalLahir = Date::excelToDateTimeObject($row['Tanggal Lahir*'])->format('Y-m-d');
    //         } catch (\Exception $e) {
    //         }
    //     }

    //     $tanggalPindah = null;
    //     if (isset($row['Tanggal Pindah/Keluar']) && is_numeric($row['Tanggal Pindah/Keluar'])) {
    //         try {
    //             $tanggalPindah = Date::excelToDateTimeObject($row['Tanggal Pindah/Keluar'])->format('Y-m-d');
    //         } catch (\Exception $e) {
    //         }
    //     }

    //     $resident = Resident::create([
    //         'national_id' => $nik,
    //         'family_card_number' => trim($row['Nomor KK*']),
    //         'full_name' => $row['Nama Lengkap*'],
    //         'gender' => array_flip(getGenderList())[$row['Jenis Kelamin*']],
    //         'birth_place' => $row['Tempat Lahir*'],
    //         'birth_date' => $tanggalLahir,
    //         'religion' => array_flip(getReligionList())[$row['Agama*']],
    //         'job' => array_flip(getJobList())[$row['Pekerjaan*']],
    //         'last_education' => array_flip(getEducationList())[$row['Pendidikan Terakhir*']],
    //         'marital_status' => array_flip(getMaritalStatusList())[$row['Status Pernikahan*']],
    //         'family_relationship' => array_flip(getFamilyRelationshipList())[$row['Hubungan Keluarga*']],
    //         'address' => $row['Alamat*'],
    //         'rt' => trim($row['Rt*']),
    //         'rw' => trim($row['Rw*']),
    //         'hamlet_village' => $row['Dusun/Kelurahan'],
    //         'death_status' => array_flip(getDeathStatusList())[$row['Status Kematian*']],
    //         'citizenship' => array_flip(getCitizenshipList())[$row['Kewarganegaraan*']],
    //         'transfer_date' => $tanggalPindah,
    //     ]);

    //     $dynamicData = [];
    //     $now = now();
    //     foreach ($this->dynamicFormMapping as $name => $id) {
    //         $dynamicData[] = [
    //             'resident_id' => $resident->id,
    //             'resident_form_id' => $id,
    //             'value' => trim($row[$name] ?? ''),
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //         ];
    //     }

    //     if (!empty($dynamicData)) {
    //         ResidentFormValue::insert($dynamicData);
    //     }

    //     return $resident;
    // }

    public function rules(): array
    {
        $genderList = array_values(getGenderList());
        $religionList = array_values(getReligionList());
        $jobList = array_values(getJobList());
        $educationList = array_values(getEducationList());
        $maritalStatusList = array_values(getMaritalStatusList());
        $familyRelationshipList = array_values(getFamilyRelationshipList());
        $deathStatusList = array_values(getDeathStatusList());
        $citizenshipList = array_values(getCitizenshipList());

        $dynamicRule = [];
        foreach (array_keys($this->dynamicFormMapping) as $name) {
            $dynamicRule[$name] = 'nullable|string';
        }

        $defaultRule = [
            'NIK*' => [
                'nullable',
                'string',
                'size:16',
                Rule::unique(Resident::class, 'national_id'),
            ],
            'Nomor KK*' => 'nullable|string|size:16',
            'Nama Lengkap*' => 'nullable|string',
            'Tempat Lahir*' => 'nullable|string',
            'Alamat*' => 'nullable|string',
            'Rt*' => 'nullable|string',
            'Rw*' => 'nullable|string',
            'Jenis Kelamin*' => ['nullable', Rule::in($genderList)],
            'Agama*' => ['nullable', Rule::in($religionList)],
            'Pekerjaan*' => ['nullable', Rule::in($jobList)],
            'Pendidikan Terakhir*' => ['nullable', Rule::in($educationList)],
            'Status Pernikahan*' => ['nullable', Rule::in($maritalStatusList)],
            'Hubungan Keluarga*' => ['nullable', Rule::in($familyRelationshipList)],
            'Status Kematian*' => ['nullable', Rule::in($deathStatusList)],
            'Kewarganegaraan*' => ['nullable', Rule::in($citizenshipList)],
            'Tanggal Lahir*' => 'nullable|numeric',
            'Tanggal Pindah/Keluar' => 'nullable|numeric',
            'Dusun/Kelurahan' => 'nullable|string',
        ];

        return array_merge($defaultRule, $dynamicRule);
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures->push($failure);

            Log::warning('IMPORT FAILURE COLLECTED:', [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
            ]);
        }
    }

    public function failures(): Collection
    {
        return $this->failures;
    }
}
