<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    public function run(): void
    {
        // Cities
        \App\Models\City::firstOrCreate(['slug' => 'samarkand'], ['name' => 'Samarkand', 'country_code' => 'UZ']);
        \App\Models\City::firstOrCreate(['slug' => 'bukhara'], ['name' => 'Bukhara', 'country_code' => 'UZ']);
        \App\Models\City::firstOrCreate(['slug' => 'tashkent'], ['name' => 'Tashkent', 'country_code' => 'UZ']);
        \App\Models\City::firstOrCreate(['slug' => 'khiva'], ['name' => 'Khiva', 'country_code' => 'UZ']);

        // Categories
        \App\Models\Category::firstOrCreate(['slug' => 'day-tours'], ['name' => 'Day Tours', 'description' => 'Single day excursions']);
        \App\Models\Category::firstOrCreate(['slug' => 'multi-day'], ['name' => 'Multi-day Tours', 'description' => 'Extended tours spanning multiple days']);
        \App\Models\Category::firstOrCreate(['slug' => 'cultural'], ['name' => 'Cultural Tours', 'description' => 'Explore historical sites and culture']);
        \App\Models\Category::firstOrCreate(['slug' => 'adventure'], ['name' => 'Adventure Tours', 'description' => 'Active and adventurous experiences']);

        // Tags
        \App\Models\Tag::firstOrCreate(['slug' => 'history'], ['name' => 'History']);
        \App\Models\Tag::firstOrCreate(['slug' => 'culture'], ['name' => 'Culture']);
        \App\Models\Tag::firstOrCreate(['slug' => 'architecture'], ['name' => 'Architecture']);
        \App\Models\Tag::firstOrCreate(['slug' => 'silk-road'], ['name' => 'Silk Road']);
        \App\Models\Tag::firstOrCreate(['slug' => 'family-friendly'], ['name' => 'Family Friendly']);
    }
}
