<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class MetaService
{
    /**
     * Compose meta tags for SEO
     *
     * @param array $data
     * @return array
     */
    public function compose(array $data): array
    {
        $siteName = config('app.name', 'Travel Agency');
        $defaultMeta = config('seo.default_meta', []);

        $meta = [
            'title' => $data['title'] ?? $defaultMeta['title'] ?? $siteName,
            'description' => $data['description'] ?? $defaultMeta['description'] ?? '',
            'keywords' => $data['keywords'] ?? $defaultMeta['keywords'] ?? '',
            'image' => $data['image'] ?? asset('images/default-og-image.jpg'),
            'url' => $data['url'] ?? url()->current(),
            'type' => $data['type'] ?? 'website',
            'canonical' => $data['canonical'] ?? url()->current(),
            'noindex' => $data['noindex'] ?? false,
            'locale' => $data['locale'] ?? app()->getLocale(),
        ];

        // Append site name to title if not present
        if (!str_contains($meta['title'], $siteName)) {
            $meta['title'] = $meta['title'] . ' | ' . $siteName;
        }

        // Twitter card defaults
        $meta['twitter_card'] = $data['twitter_card'] ?? 'summary_large_image';
        $meta['twitter_site'] = $data['twitter_site'] ?? config('seo.twitter_handle', '');

        // OpenGraph
        $meta['og_title'] = $data['og_title'] ?? $meta['title'];
        $meta['og_description'] = $data['og_description'] ?? $meta['description'];
        $meta['og_image'] = $data['og_image'] ?? $meta['image'];
        $meta['og_url'] = $data['og_url'] ?? $meta['url'];
        $meta['og_type'] = $data['og_type'] ?? $meta['type'];
        $meta['og_locale'] = $data['og_locale'] ?? $meta['locale'];

        return $meta;
    }

    /**
     * Generate meta tags HTML
     *
     * @param array $meta
     * @return string
     */
    public function render(array $meta): string
    {
        $html = '';

        // Basic meta
        $html .= '<title>' . e($meta['title']) . '</title>' . PHP_EOL;
        $html .= '<meta name="description" content="' . e($meta['description']) . '">' . PHP_EOL;

        if (!empty($meta['keywords'])) {
            $html .= '<meta name="keywords" content="' . e($meta['keywords']) . '">' . PHP_EOL;
        }

        // Canonical
        $html .= '<link rel="canonical" href="' . e($meta['canonical']) . '">' . PHP_EOL;

        // Robots
        if ($meta['noindex']) {
            $html .= '<meta name="robots" content="noindex, nofollow">' . PHP_EOL;
        }

        // OpenGraph
        $html .= '<meta property="og:title" content="' . e($meta['og_title']) . '">' . PHP_EOL;
        $html .= '<meta property="og:description" content="' . e($meta['og_description']) . '">' . PHP_EOL;
        $html .= '<meta property="og:image" content="' . e($meta['og_image']) . '">' . PHP_EOL;
        $html .= '<meta property="og:url" content="' . e($meta['og_url']) . '">' . PHP_EOL;
        $html .= '<meta property="og:type" content="' . e($meta['og_type']) . '">' . PHP_EOL;
        $html .= '<meta property="og:locale" content="' . e($meta['og_locale']) . '">' . PHP_EOL;

        // Twitter Card
        $html .= '<meta name="twitter:card" content="' . e($meta['twitter_card']) . '">' . PHP_EOL;
        $html .= '<meta name="twitter:title" content="' . e($meta['og_title']) . '">' . PHP_EOL;
        $html .= '<meta name="twitter:description" content="' . e($meta['og_description']) . '">' . PHP_EOL;
        $html .= '<meta name="twitter:image" content="' . e($meta['og_image']) . '">' . PHP_EOL;

        if (!empty($meta['twitter_site'])) {
            $html .= '<meta name="twitter:site" content="' . e($meta['twitter_site']) . '">' . PHP_EOL;
        }

        return $html;
    }
}
