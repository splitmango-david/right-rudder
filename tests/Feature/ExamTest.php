<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_lists_published_exams_only(): void
    {
        Exam::factory()->create(['title' => 'Visible Exam']);
        Exam::factory()->unpublished()->create(['title' => 'Hidden Exam']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Visible Exam')
            ->assertDontSee('Hidden Exam');
    }

    public function test_exam_page_renders_sections_without_leaking_answers(): void
    {
        $question = Question::factory()->create(['correct_option' => 3]);
        $exam = $question->exam;

        $response = $this->get(route('exams.show', $exam))->assertOk();

        $response->assertSee($question->section->name);
        $response->assertSee($question->stem, escape: false);
        $response->assertDontSee('correct_option');
    }

    public function test_unpublished_exam_returns_not_found(): void
    {
        $exam = Exam::factory()->unpublished()->create();

        $this->get(route('exams.show', $exam))->assertNotFound();
    }
}
