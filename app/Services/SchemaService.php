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

    public function tourDetail(Tour $tour): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TouristTrip',
            'name' => $tour->title,
            'description' => strip_tags($tour->excerpt ?: $tour->description_html),
            'url' => route('tours.show', $tour->slug),
        ];

        if ($tour->priceOptions->where('is_active', true)->isNotEmpty()) {
            $firstPrice = $tour->priceOptions->where('is_active', true)->first();
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => $firstPrice->price,
                'priceCurrency' => $firstPrice->currency ?? 'USD',
                'availability' => 'https://schema.org/InStock',
            ];
        }

        if ($tour->average_rating && $tour->reviews_count) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $tour->average_rating,
                'reviewCount' => $tour->reviews_count,
            ];
        }

        return $schema;
    }

    public function blogPost(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->title,
            'description' => strip_tags($post->excerpt ?? ''),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author?->name ?? 'Unknown',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'url' => url('/'),
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('blog.show', $post->slug),
            ],
        ];
    }
}

