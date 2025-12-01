<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Resident\App\Models\Resident;
use Modules\Resident\App\Models\ResidentForm;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ResidentExport implements FromQuery, WithMapping, WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;

    protected Request $request;
    protected $formIds = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->formIds = ResidentForm::pluck('id')->toArray();
    }

    public function query()
    {
        $query = Resident::query()->with('resident_form_value');

        if ($this->request->input('village')) {
            $query->where(DB::raw('LOWER(hamlet_village)'), strtolower($this->request->input('village')));
        }

        if ($this->request->input('age') && is_numeric($this->request->input('age'))) {
            $query->where(DB::raw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE())'), '=', $this->request->input('age'));
            $query->whereNotNull('birth_date');

            Log::info('SQL Query Umur: ' . $query->toSql());
            Log::info('Bindings Umur: ' . json_encode($query->getBindings()));
        }

        return $query;
    }

    public function headings(): array
    {
        return (new ResidentTemplateExport())->headings();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function ($event) {
                $templateExporter = new ResidentTemplateExport();
                $templateEvents = $templateExporter->registerEvents();

                $templateEvents[AfterSheet::class]($event);
            },
        ];
    }

    public function map($resident): array
    {
        $genderList = getGenderList();
        $religionList = getReligionList();
        $jobList = getJobList();
        $educationList = getEducationList();
        $maritalStatusList = getMaritalStatusList();
        $familyRelationshipList = getFamilyRelationshipList();
        $deathStatusList = getDeathStatusList();
        $citizenshipList = getCitizenshipList();

        // $birthDateExcel = $resident->birth_date ? Date::dateTimeToExcel($resident->birth_date) : '';
        // $transferDateExcel = $resident->transfer_date ? Date::dateTimeToExcel($resident->transfer_date) : '';

        $birthDateExcel = '';
        if ($resident->birth_date) {
            $dateObject = ($resident->birth_date instanceof \DateTimeInterface)
                ? $resident->birth_date
                : Carbon::parse($resident->birth_date);
            $birthDateExcel = Date::dateTimeToExcel($dateObject);
        }

        $transferDateExcel = '';
        if ($resident->transfer_date) {
            $dateObject = ($resident->transfer_date instanceof \DateTimeInterface)
                ? $resident->transfer_date
                : Carbon::parse($resident->transfer_date);
            $transferDateExcel = Date::dateTimeToExcel($dateObject);
        }

        $formValues = $resident->resident_form_value->pluck('value', 'resident_form_id')->toArray();

        $dynamicData = [];
        foreach ($this->formIds as $formId) {
            $dynamicData[] = $formValues[$formId] ?? '';
        }

        $defaultData = [
            "'" . $resident->national_id,
            "'" . $resident->family_card_number,
            $resident->full_name,
            $genderList[$resident->gender],
            $resident->birth_place,
            $birthDateExcel,
            $religionList[$resident->religion],
            $jobList[$resident->job],
            $educationList[$resident->last_education],
            $maritalStatusList[$resident->marital_status],
            $familyRelationshipList[$resident->family_relationship],
            $resident->address,
            $resident->rt,
            $resident->rw,
            $resident->hamlet_village,
            $deathStatusList[$resident->death_status],
            $citizenshipList[$resident->citizenship],
            $transferDateExcel,
        ];

        return array_merge($defaultData, $dynamicData);
    }
}
