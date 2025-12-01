<?php

namespace Modules\VillageOfficial\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\VillageOfficial\App\Models\VillageOfficialMember;

class VillageOfficialMemberUserController extends Controller
{
    public function __invoke()
    {
        $villageOfficialMembers = VillageOfficialMember::with('resident')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('villageofficial::user.member.index', [
            'villageOfficialMembers' => $villageOfficialMembers,
        ]);
    }
}
