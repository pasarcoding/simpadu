<?php

namespace Modules\Contact\App\Http\Services;

use App\Constants\PermissionName;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\CritiqueSuggestion\App\Models\CritiqueSuggestion;
use Yajra\DataTables\Facades\DataTables;

class CritiqueSuggestionUserService
{
    public function critique_suggestion($data)
    {
        DB::beginTransaction();
        try {
            $critiqueSuggestion = CritiqueSuggestion::create($data);

            DB::commit();
            return $critiqueSuggestion;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
