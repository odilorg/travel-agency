<?php

namespace App\Services;

use App\Models\{Tour, Post, SiteSetting};
use Illuminate\Support\Facades\Cache;

class SchemaService
{
    public function organization(): array
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return SiteSetting::first();
        });

        return [
            '@context' => 'https://schema.org',
            '@type' => 'TravelAgency',
            'name' => $settings?->site_name ?? config('app.name'),
            'url' => url('/'),
            'sameAs' => array_values($settings?->social_links ?? []),
        ];
    }

    public function tourProduct(Tour $tour): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $tour->title,
            'description' => strip_tags($tour->excerpt ?? ''),
            'url' => route('tours.show', $tour->slug),
            'offers' => [
                '@type' => 'Offer',
                'price' => $tour->price_from,
                'priceCurrency' => $tour->currency ?? 'USD',
                'availability' => 'https://schema.org/InStock',
            ],
        ];
    }

    public function article(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => strip_tags($post->excerpt ?? ''),
            'datePublished' => $post->published_at?->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author?->name ?? 'Unknown',
            ],
        ];
    }

    public function breadcrumbs(array $items): array
    {
        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }
}

