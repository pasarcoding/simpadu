<?php

namespace App\View\Composer;

use Illuminate\View\View;
use Modules\Setting\App\Models\Setting;

class SettingComposer
{
    public function compose(View $view)
    {
        $settings = Setting::get();

        $view->with('setting_app', $settings->firstWhere('key', 'app')?->value)
            ->with('setting_appearance', $settings->firstWhere('key', 'appearance')?->value)
            ->with('setting_contact', $settings->firstWhere('key', 'contact')?->value)
            ->with('setting_e_letter', $settings->firstWhere('key', 'e_letter')?->value);
    }
}
