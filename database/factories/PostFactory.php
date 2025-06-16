<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Author; // ou Author, dependendo da tua app
use App\Models\Category;

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
         $title = $this->faker->unique()->sentence(6, true);

        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title) . '-' . Str::random(5), // evita slug duplicado
            'excerpt' => $this->faker->optional()->paragraph(),
            'content' => $this->faker->paragraphs(5, true),
            'featured_image' => $this->faker->optional()->imageUrl(800, 600, 'nature', true),
            'author_id' => Author::factory(), // ou Author::factory()
            'category_id' => Category::factory(),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'published_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'meta_title' => $this->faker->optional()->sentence(),
            'meta_description' => $this->faker->optional()->paragraph(),
            'views_count' => $this->faker->numberBetween(0, 10000),
        ];
    }
}
