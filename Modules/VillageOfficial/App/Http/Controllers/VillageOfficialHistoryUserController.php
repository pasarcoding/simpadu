<?php

namespace Modules\VillageOfficial\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\VillageOfficial\App\Models\VillageOfficialHistory;

class VillageOfficialHistoryUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $villageOfficialHistory = VillageOfficialHistory::firstOrNew([]);

        return view('villageofficial::user.history.index', [
            'villageOfficialHistory' => $villageOfficialHistory,
        ]);
    }
}
