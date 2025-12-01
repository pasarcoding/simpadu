<?php

namespace Modules\VillageOfficial\App\Http\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Modules\VillageOfficial\App\Models\VillageOfficialHistory;
use Yajra\DataTables\Facades\DataTables;

class VillageOfficialHistoryService
{
    public function get()
    {
        return VillageOfficialHistory::firstOrNew([]);
    }

    public function update($data)
    {
        $history = $this->get();

        DB::beginTransaction();
        try {
            $history->fill($data);
            $history->save();

            DB::commit();
            return $history;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy()
    {
        $history = $this->get();

        DB::beginTransaction();
        try {
            $delete = $history->delete();

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
