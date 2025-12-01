<?php

namespace Modules\VillageOfficial\App\Http\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\VillageOfficial\App\Models\VillageOfficialVisionMission;

class VillageOfficialVisionMissionService
{
    public function get()
    {
        return VillageOfficialVisionMission::firstOrNew([]);
    }

    public function update($data)
    {
        $visionMission = $this->get();

        DB::beginTransaction();
        try {
            $visionMission->fill($data);
            $visionMission->save();

            DB::commit();
            return $visionMission;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy()
    {
        $visionMission = $this->get();

        DB::beginTransaction();
        try {
            $delete = $visionMission->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
