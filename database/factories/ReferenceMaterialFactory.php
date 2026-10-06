<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ReferenceMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReferenceMaterial>
 */
class ReferenceMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'key' => fake()->unique()->lexify('ref-????'),
            'title' => fake()->words(3, true),
            'text' => fake()->paragraph(),
        ];
    }
}
