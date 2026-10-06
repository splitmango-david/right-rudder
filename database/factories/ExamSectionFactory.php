<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ExamSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamSection>
 */
class ExamSectionFactory extends Factory
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
            'key' => fake()->unique()->lexify('sec-????'),
            'name' => fake()->words(2, true),
            'short_name' => null,
            'position' => 0,
        ];
    }
}
