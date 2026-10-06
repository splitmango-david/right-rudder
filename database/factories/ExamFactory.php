<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(2),
            'title' => fake()->words(3, true),
            'heading' => fake()->sentence(4),
            'category' => fake()->words(4, true),
            'reference' => null,
            'description' => fake()->paragraph(),
            'notes' => null,
            'pass_mark' => 60,
            'external_chart_note' => null,
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn () => ['is_published' => false]);
    }
}
