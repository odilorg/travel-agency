<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(4, true);

        return [
            'title' => ucfirst($title),
            'slug' => fake()->slug(),
            'excerpt' => fake()->sentence(15),
            'description_html' => '<p>' . fake()->paragraphs(5, true) . '</p>',
            'duration_days' => fake()->numberBetween(1, 14),
            'duration_nights' => fake()->numberBetween(0, 13),
            'price_from' => fake()->randomFloat(2, 50, 5000),
            'currency' => 'USD',
            'city_id' => \App\Models\City::inRandomOrder()->first()?->id,
            'difficulty' => fake()->randomElement(['easy', 'moderate', 'hard']),
            'is_featured' => fake()->boolean(30),
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'avg_rating' => fake()->randomFloat(1, 3.5, 5.0),
            'reviews_count' => fake()->numberBetween(0, 100),
            'meta_title' => ucfirst($title),
            'meta_description' => fake()->text(160),
        ];
    }
}
