<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create 10 categories
        $categories = \App\Models\Category::factory(10)->create();

        // Create 10 tags
        $tags = \App\Models\Tag::factory(10)->create();

        // Create 10 tours with random categories and tags
        \App\Models\Tour::factory(10)->create()->each(function ($tour) use ($categories, $tags) {
            $tour->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
            $tour->tags()->attach(
                $tags->random(rand(1, 4))->pluck('id')->toArray()
            );
        });

        // Create 10 blog posts with random categories and tags
        \App\Models\Post::factory(10)->create()->each(function ($post) use ($categories, $tags) {
            $post->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')->toArray()
            );
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
