<?php

namespace App\View\Composer;

use Illuminate\View\View;
use Modules\Information\App\Models\Information;
use Modules\News\App\Models\News;

class NewsInformationComposer
{
    public function compose(View $view)
    {
        $topNews = News::where('status', 'publish')->latest()->take(5)->get();
        $topInformations = Information::where('status', 'publish')->latest()->take(5)->get();

        $view->with('topNews', $topNews)
            ->with('topInformations', $topInformations);
    }
}
