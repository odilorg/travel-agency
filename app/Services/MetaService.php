<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\Tour;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class MetaService
{
    public function compose(
        ?string $title = null,
        ?string $description = null,
        ?string $image = null,
        ?string $canonical = null,
        array $robots = ['index' => true, 'follow' => true],
        array $og = []
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
            'noindex' => !($robots['index'] ?? true),
            'og' => array_merge([
                'og:title' => $title ?? $siteName,
                'og:description' => $description ?? '',
                'og:image' => $image ?? null,
                'og:url' => $canonical ?? url()->current(),
                'og:type' => 'website',
            ], $og),
        ];
    }

    public function forTour(Tour $tour): array
    {
        $title = $tour->meta_title ?: ($tour->title . ' - ' . config('app.name'));
        $description = $tour->meta_description ?: Str::limit(strip_tags($tour->excerpt ?: $tour->description_html), 160);
        $image = method_exists($tour, 'getFirstMediaUrl') ? $tour->getFirstMediaUrl('gallery', 'card') : null;

        return $this->compose(
            title: $title,
            description: $description,
            image: $image,
            canonical: $tour->canonical_url ?: url()->current(),
            robots: ['index' => !($tour->noindex ?? false), 'follow' => true],
            og: [
                'og:type' => 'article',
                'og:image' => $image,
            ]
        );
    }

    public function forPost(Post $post): array
    {
        $title = $post->meta_title ?: ($post->title . ' - ' . config('app.name'));
        $description = $post->meta_description ?: Str::limit(strip_tags($post->excerpt ?: $post->body_html), 160);
        $image = $post->featured_image ?? null;

        return $this->compose(
            title: $title,
            description: $description,
            image: $image,
            canonical: $post->canonical_url ?: url()->current(),
            robots: ['index' => !($post->noindex ?? false), 'follow' => true],
            og: [
                'og:type' => 'article',
                'article:published_time' => $post->published_at?->toIso8601String(),
                'article:author' => $post->author?->name,
                'og:image' => $image,
            ]
        );
    }
}

