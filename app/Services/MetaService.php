<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class MetaService
{
    public function compose(
        ?string $title = null,
        ?string $description = null,
        ?string $image = null,
        ?string $canonical = null,
        bool $noindex = false,
        array $extra = []
    ): array {
        $settings = Cache::remember('site_settings', 3600, function () {
            return SiteSetting::first();
        });

        $defaultMeta = $settings?->default_meta ?? [];
        $siteName = $settings?->site_name ?? config('app.name');

        return [
            'title' => $title ?? $defaultMeta['title'] ?? $siteName,
            'description' => $description ?? $defaultMeta['description'] ?? '',
            'image' => $image ?? $defaultMeta['image'] ?? null,
            'canonical' => $canonical ?? url()->current(),
            'noindex' => $noindex,
            'extra' => array_merge($defaultMeta, $extra),
        ];
    }
}

