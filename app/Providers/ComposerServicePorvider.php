<?php

namespace App\Providers;

use App\View\Composer\NewsInformationComposer;
use App\View\Composer\SettingComposer;
use App\View\Composer\UserMenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServicePorvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(
            [
                'villageofficial::user.history.index',
                'villageofficial::user.vision_mission.index',
                'information::user.index',
                'information::user.detail',
                'news::user.index',
                'news::user.detail',
                'appearance::user.page.index',
                'eletter::user.index',
            ],
            NewsInformationComposer::class
        );
        View::composer(
            [
                'user.layouts.header',
                'user.layouts.bottom-sheet-menu',
                'user.layouts.footer',
            ],
            UserMenuComposer::class
        );
        View::composer(
            [
                'authentication::admin.login',
                'setting::admin.index',
                'admin.layouts.app',
                'admin.layouts.sidebar',
                'user.layouts.app',
                'user.layouts.header',
                'user.layouts.top-content',
                'user.layouts.footer',
                'homepage::user.index',
                'contact::user.index',
            ],
            SettingComposer::class
        );
    }
}
