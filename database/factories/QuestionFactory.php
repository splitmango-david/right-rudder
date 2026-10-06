<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ExamSection;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
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
            'exam_section_id' => fn (array $attributes) => ExamSection::factory()->create(['exam_id' => $attributes['exam_id']]),
            'number' => fake()->unique()->numberBetween(1, 10000),
            'stem' => fake()->sentence().'?',
            'options' => [fake()->sentence(3), fake()->sentence(3), fake()->sentence(3), fake()->sentence(3)],
            'correct_option' => fake()->numberBetween(1, 4),
            'requires_external_chart' => false,
        ];
    }
}
