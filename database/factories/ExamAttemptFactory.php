<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExamAttempt>
 */
class ExamAttemptFactory extends Factory
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
            'user_id' => null,
            'session_id' => null,
            'section_keys' => [],
            'answers' => [],
            'flags' => [],
            'section_results' => [],
            'correct_count' => 0,
            'question_count' => 0,
            'score' => 0,
            'passed' => false,
            'started_at' => now()->subMinutes(30),
            'submitted_at' => now(),
        ];
    }
}
