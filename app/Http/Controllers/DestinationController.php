<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $destinations = Destination::query()
            ->where('status', 'published')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            })
            ->with(['media', 'country'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(12);

        return view('destinations.index', compact('destinations'));
    }

    public function show(Destination $destination)
    {
        // Eager load relations
        $destination->load([
            'media',
            'activities',
            'items.media',
            'country',
        ]);

        // Get published tours for this destination
        $tours = $destination->tours()
            ->where('status', 'published')
            ->with(['media', 'categories', 'tags', 'city'])
            ->paginate(12);

        // Get top destinations (cached weekly)
        $topDestinations = cache()->remember('top_destinations_v1', 60 * 60 * 24 * 7, function () use ($destination) {
            return Destination::query()
                ->where('is_featured', true)
                ->whereKeyNot($destination->getKey())
                ->where('status', 'published')
                ->orderBy('order')
                ->orderByDesc(
                    Tour::selectRaw('count(*)')
                        ->whereColumn('tours.destination_id', 'destinations.id')
                        ->where('tours.status', 'published')
                )
                ->with(['media', 'country'])
                ->take(10)
                ->get();
        });

        // Meta data
        $metaData = $this->buildMetaData($destination);

        // Breadcrumb JSON-LD
        $breadcrumbJson = $this->buildBreadcrumbJson($destination);

        // Destination JSON-LD
        $destinationJson = $this->buildDestinationJson($destination);

        return view('destinations.show', compact(
            'destination',
            'tours',
            'topDestinations',
            'metaData',
            'breadcrumbJson',
            'destinationJson'
        ));
    }

    protected function buildMetaData(Destination $destination): array
    {
        return [
            'title' => $destination->meta_title ?: $destination->name . ' — ' . config('app.name'),
            'description' => $destination->meta_description ?: \Illuminate\Support\Str::limit(
                strip_tags($destination->excerpt ?: $destination->description_html),
                160
            ),
            'canonical' => $destination->canonical_url ?: url()->current(),
            'robots' => [
                'index' => !$destination->noindex,
                'follow' => true,
            ],
            'og' => [
                'og:title' => $destination->meta_title ?: $destination->name,
                'og:description' => $destination->meta_description ?: \Illuminate\Support\Str::limit(
                    strip_tags($destination->excerpt ?: $destination->description_html),
                    160
                ),
                'og:image' => $destination->getFirstMediaUrl('banner'),
                'og:type' => 'website',
            ],
        ];
    }

    protected function buildBreadcrumbJson(Destination $destination): string
    {
        $items = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Destinations', 'url' => route('destinations.index')],
            ['name' => $destination->name, 'url' => request()->url()],
        ];

        $breadcrumb = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->map(function ($item, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ];
            })->toArray(),
        ];

        return json_encode($breadcrumb, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    protected function buildDestinationJson(Destination $destination): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Place',
            'name' => $destination->name,
            'description' => strip_tags($destination->excerpt ?: $destination->description_html),
        ];

        if ($destination->getFirstMediaUrl('banner')) {
            $data['image'] = $destination->getFirstMediaUrl('banner');
        }

        if ($destination->country) {
            $data['address'] = [
                '@type' => 'PostalAddress',
                'addressCountry' => $destination->country->name,
            ];
        }

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
