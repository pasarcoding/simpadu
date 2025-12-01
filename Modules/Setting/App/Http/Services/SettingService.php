<?php

namespace Modules\Setting\App\Http\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\ELetter\App\Models\ELetterSubmission;
use Modules\Setting\App\Models\Setting;

class SettingService
{
    public function app($data)
    {
        $appSetting = Setting::firstWhere('key', 'app')?->value;

        $oldImage = $appSetting['logo'] ?? null;
        $newImage = null;

        if (isset($data['logo']) && $data['logo']->isValid()) {
            $newImage = $data['logo']->store('setting', 'public');
            $data['logo'] = $newImage;
        } else {
            if (empty($appSetting)) {
                $data['logo'] = null;
            } else {
                $data['logo'] = $oldImage;
            }
        }

        DB::beginTransaction();
        try {
            $setting = Setting::updateOrCreate(
                ['key' => 'app'],
                ['value' => $data]
            );

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function appearance($data)
    {
        $appearanceSetting = Setting::firstWhere('key', 'appearance')?->value;

        $oldImage = $appearanceSetting['background_banner'] ?? null;
        $newImage = null;

        if (isset($data['background_banner']) && $data['background_banner']->isValid()) {
            $newImage = $data['background_banner']->store('setting', 'public');
            $data['background_banner'] = $newImage;
        } else {
            if (empty($appearanceSetting)) {
                $data['background_banner'] = null;
            } else {
                $data['background_banner'] = $oldImage;
            }
        }

        DB::beginTransaction();
        try {
            $setting = Setting::updateOrCreate(
                ['key' => 'appearance'],
                ['value' => $data]
            );

            if ($newImage && $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollBack();

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }
    }

    public function contact($data)
    {
        DB::beginTransaction();
        try {
            $setting = Setting::updateOrCreate(
                ['key' => 'contact'],
                ['value' => $data]
            );

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function e_letter($data)
    {
        DB::beginTransaction();
        try {
            $setting = Setting::updateOrCreate(
                ['key' => 'e_letter'],
                ['value' => $data]
            );

            DB::commit();
            return $setting;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function e_letter_parse_message(ELetterSubmission $eLetterSubmission = null, $type = null)
    {
        $data_keys = [
            '${nama_penduduk}',
            '${nik_penduduk}',
            '${jenis_surat}',
            '${nomor_surat}',
            '${aplikasi}',
        ];

        if ($eLetterSubmission == null) {
            return $data_keys;
        }

        $eLetterSubmission->load(['e_letter_template', 'resident']);

        $settings = Setting::get();

        $data_values = [
            $eLetterSubmission->resident->full_name ?? '',
            $eLetterSubmission->national_id,
            $eLetterSubmission->e_letter_template->name,
            $eLetterSubmission->letter_number,
            $settings->firstWhere('key', 'app')->value['name'] ?? config('app.name'),
        ];

        $message_success = $settings->firstWhere('key', 'e_letter')->value['success'] ?? '';
        $message_reject = $settings->firstWhere('key', 'e_letter')->value['reject'] ?? '';

        $message = $type == 'completed' ? $message_success : $message_reject;

        return urlencode(str_replace($data_keys, $data_values, $message));
    }
}
