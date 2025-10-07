<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6, true);

        return [
            'title' => rtrim($title, '.'),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->sentence(20),
            'body_html' => '<p>' . implode('</p><p>', fake()->paragraphs(8)) . '</p>',
            'author_id' => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory()->create()->id,
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'meta_title' => rtrim($title, '.'),
            'meta_description' => fake()->text(160),
            'noindex' => false,
        ];
    }
}
