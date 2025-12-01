<?php

namespace Modules\ELetter\App\Http\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\ELetter\App\Models\ELetterSequence;
use Modules\ELetter\App\Models\ELetterSubmission;
use Modules\ELetter\App\Models\ELetterTemplate;
use Modules\Resident\App\Models\Resident;
use PDO;

class ELetterSubmissionUserService
{

    public function searchResidentByNationalID($e_letter_template_id, $national_id)
    {
        try {
            $eLetterTemplate = ELetterTemplate::find($e_letter_template_id);
            if (!$eLetterTemplate) {
                return [];
            }

            $listVariables = json_decode($eLetterTemplate->list_variables);

            $residentData = [];
            $resident = Resident::where('national_id', $national_id)->first();
            if (!$resident) {
                return [];
            }

            $variableResidentReverse = array_flip(getResidentVaribleTemplateList());
            foreach ($listVariables as $item) {
                if (isset($variableResidentReverse[$item->name])) {
                    $residentColumn = $variableResidentReverse[$item->name];

                    $residentValue = '';
                    if ($resident && isset($resident->{$residentColumn})) {
                        $residentValue = $resident->{$residentColumn};
                    }

                    $residentData[$item->name] = $residentValue;
                }
            }

            return $residentData;
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function generateLetterSequence()
    {
        $today = Carbon::today()->format('Y-m-d');

        $sequence = ELetterSequence::lockForUpdate()->firstOrCreate(
            ['date' => $today],
            ['sequence' => 0]
        );
        $sequence->increment('sequence');
        return Carbon::today()->format('dmY') . str_pad($sequence->sequence, 4, '0', STR_PAD_LEFT);
    }

    public function store($data)
    {
        $formDatas = $data['form'];
        $formDataProcess = [];
        $newFiles = [];

        $eLetterTemplate = ELetterTemplate::where('id', $data['e_letter_template_id'])
            ->lockForUpdate()
            ->firstOrFail();
        $listVariables = json_decode($eLetterTemplate->list_variables);

        foreach ($formDatas as $name => $value) {
            if ($value instanceof UploadedFile) {
                if (isset($formDatas[$name]) && $formDatas[$name]->isValid()) {
                    $newFile = $formDatas[$name]->store('e_letter_submission', 'public');
                    $formDataProcess[$name] = $newFile;
                    $newFiles[] = $newFile;
                }
            } else {
                $formDataProcess[$name] = $value;
            }
        }

        $formDataProcess = collect($formDataProcess);
        $formDataProcess = collect($listVariables)->map(function ($item) use ($formDataProcess) {
            $item->value = $formDataProcess->get($item->name);
            return $item;
        })->toArray();

        $nationalId = Resident::where('national_id', $data['national_id'])->first()?->id;

        unset($data['form']);

        DB::beginTransaction();
        try {
            $lastNumber = (int)$eLetterTemplate->last_sequence_number;
            $paddingLength = $eLetterTemplate->padding_sequence_length;

            $nextNumber = $lastNumber + 1;
            $paddingLength = max($paddingLength, strlen((string) $nextNumber));

            $eLetterTemplate->last_sequence_number = $nextNumber;
            $eLetterTemplate->padding_sequence_length = $paddingLength;
            $eLetterTemplate->save();

            $data['resident_id'] = $nationalId;
            $data['letter_number'] = str_pad($nextNumber, $paddingLength, '0', STR_PAD_LEFT);
            $data['list_variable_with_values'] = json_encode($formDataProcess);
            $data['status'] = 'submitted';

            $eLetterSubmission = ELetterSubmission::create($data);

            DB::commit();
            return $eLetterSubmission;
        } catch (Exception $e) {
            DB::rollBack();

            foreach ($newFiles as $item) {
                Storage::disk('public')->delete($item);
            }

            throw $e;
        }
    }
}
