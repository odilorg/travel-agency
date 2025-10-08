<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;

class AboutController extends Controller
{
    public function show()
    {
        $settings = SiteSetting::getInstance();
        
        $metaData = [
            'title' => __('About Us') . ' - ' . ($settings->site_name ?? config('app.name')),
            'description' => $settings->about_provide_text ?? __('Learn more about our company, mission, vision, and team.'),
            'canonical' => route('about'),
            'og' => [
                'og:title' => __('About Us') . ' - ' . ($settings->site_name ?? config('app.name')),
                'og:description' => $settings->about_provide_text ?? __('Learn more about our company.'),
                'og:type' => 'website',
                'og:url' => route('about'),
            ],
        ];
        
        return view('pages.about', compact('settings', 'metaData'));
    }
}

