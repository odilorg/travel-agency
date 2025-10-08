<?php

namespace App\Http\ViewComposers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class SiteSettingComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $siteSettings = cache()->remember('site_settings_global', 3600, function () {
            return SiteSetting::getInstance();
        });

        $view->with('siteSettings', $siteSettings);
    }
}

