<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Post, Tour, City};

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure at least a couple cities exist
        $cities = [
            ['name' => 'Tokyo', 'slug' => 'tokyo', 'country_code' => 'JP'],
            ['name' => 'Bali', 'slug' => 'bali', 'country_code' => 'ID'],
            ['name' => 'Maldives', 'slug' => 'maldives', 'country_code' => 'MV'],
        ];
        foreach ($cities as $c) {
            City::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // Create 10 tours
        for ($i = 1; $i <= 10; $i++) {
            $title = "Sample Tour {$i}";
            $tour = Tour::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'excerpt' => 'Discover amazing places with our guided experiences.',
                    'description_html' => '<p>This is a demo tour description.</p>',
                    'status' => 'published',
                    'published_at' => now()->subDays(20 - $i),
                    'duration_days' => rand(1, 7),
                    'duration_nights' => rand(0, 6),
                    'price_from' => rand(50, 300),
                    'currency' => 'USD',
                    'city_id' => City::inRandomOrder()->value('id'),
                ]
            );
        }

        // Create 10 posts
        for ($i = 1; $i <= 10; $i++) {
            $title = "Sample Blog Post {$i}";
            Post::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'excerpt' => 'Short summary for sample blog post.',
                    'body_html' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.</p>',
                    'author_id' => 1,
                    'status' => 'published',
                    'published_at' => now()->subDays(10 - $i),
                    'noindex' => false,
                ]
            );
        }
    }
}


