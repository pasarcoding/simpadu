<?php

namespace Modules\VillageOfficial\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\VillageOfficial\App\Models\VillageOfficialVisionMission;

class VillageOfficialVissionMissionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $villageOfficialVisionMission = VillageOfficialVisionMission::firstOrNew([]);

        return view('villageofficial::user.vision_mission.index', [
            'villageOfficialVisionMission' => $villageOfficialVisionMission,
        ]);
    }
}
