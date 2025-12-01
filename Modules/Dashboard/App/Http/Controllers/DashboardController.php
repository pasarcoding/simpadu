<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\ELetter\App\Models\ELetterSubmission;
use Modules\News\App\Models\News;
use Modules\Resident\App\Models\Resident;

class DashboardController extends Controller
{

    public function __invoke()
    {
        $residentCount = Resident::count();
        $newsCount = News::count();
        $eLetterPendingCount = ELetterSubmission::where('status', 'submitted')->count();
        $eLetterSuccessCount = ELetterSubmission::where('status', 'completed')->count();
        $eLetterRejectCount = ELetterSubmission::where('status', 'rejected')->count();
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
        ];
        $residentReligions = Resident::select('religion', DB::raw('COUNT(*) as total'))
            ->where('death_status', 'hidup')
            ->groupBy('religion')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->religion => $item->total];
            });
        $residentReligions = collect(getReligionList())->map(function ($label, $key) use ($residentReligions) {
            return [
                'label' => $label,
                'value' => $residentReligions->get($key, 0),
            ];
        });
        $residentReligions = (object)[
            'label' => $residentReligions->pluck('label')->toArray(),
            'value' => $residentReligions->pluck('value')->toArray(),
        ];
        $residentJobs = Resident::select('job', DB::raw('COUNT(*) as total'))
            ->where('death_status', 'hidup')
            ->groupBy('job')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->job => $item->total];
            });
        $residentJobs = collect(getJobList())->map(function ($label, $key) use ($residentJobs) {
            return [
                'label' => $label,
                'value' => $residentJobs->get($key, 0),
            ];
        });
        $residentJobs = (object)[
            'label' => $residentJobs->pluck('label')->toArray(),
            'value' => $residentJobs->pluck('value')->toArray(),
        ];

        return view('dashboard::dashboard', [
            'residentCount' => $residentCount,
            'newsCount' => $newsCount,
            'eLetterPendingCount' => $eLetterPendingCount,
            'eLetterSuccessCount' => $eLetterSuccessCount,
            'eLetterRejectCount' => $eLetterRejectCount,
            'residentGenders' => $residentGenders,
            'residentReligions' => $residentReligions,
            'residentJobs' => $residentJobs,
        ]);
    }
}
