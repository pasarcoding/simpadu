<?php

namespace Modules\Homepage\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Budget\App\Models\Budget;
use Modules\Gallery\App\Models\Gallery;
use Modules\Information\App\Models\Information;
use Modules\News\App\Models\News;
use Modules\Resident\App\Models\Resident;
use Modules\SynergyProgram\App\Models\SynergyProgram;
use Modules\VillageOfficial\App\Models\VillageOfficialGreeting;
use Modules\VillageOfficial\App\Models\VillageOfficialMember;

class HomepageController extends Controller
{
    public function __invoke()
    {
        $informations = Information::where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $residentGenders = Resident::select('gender', DB::raw('COUNT(*) as total'))
            ->where('death_status', 'hidup')
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->gender => $item->total];
            });
        $residentGenders = collect(getGenderList())->map(function ($label, $key) use ($residentGenders) {
            return [
                'label' => $label,
                'value' => $residentGenders->get($key, 0),
            ];
        });
        $residentGenders = (object)[
            'label' => $residentGenders->pluck('label')->toArray(),
            'value' => $residentGenders->pluck('value')->toArray(),
            'total' => $residentGenders->sum('value'),
        ];
        $villageOfficialGreeting = VillageOfficialGreeting::first();
        $villageOfficialMembers = VillageOfficialMember::with('resident')
            ->get();
        $news = News::with('user')
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $news = (object)[
            'topNews' => $news->first(),
            'childrenNews' => $news->slice(1),
        ];
        $galleries = Gallery::orderBy('created_at', 'desc')->limit(10)->get();
        $budgets = Budget::where('type', 'progress')
            ->with('item_budget')
            ->withSum([
                'item_budget as total_in' => function ($query) {
                    $query->where('type', 'in');
                }
            ], 'nominal')
            ->withSum([
                'item_budget as total_out' => function ($query) {
                    $query->where('type', 'out');
                }
            ], 'nominal')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        $synergyPrograms = SynergyProgram::select('name', 'image')->orderBy('created_at', 'desc')->get();

        return view('homepage::user.index', [
            'informations' => $informations,
            'residentGenders' => $residentGenders,
            'villageOfficialGreeting' => $villageOfficialGreeting,
            'villageOfficialMembers' => $villageOfficialMembers,
            'news' => $news,
            'galleries' => $galleries,
            'budgets' => $budgets,
            'synergyPrograms' => $synergyPrograms,
        ]);
    }
}
