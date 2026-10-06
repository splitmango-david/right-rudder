<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamSection;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ExamAttemptTest extends TestCase
{
    use RefreshDatabase;

    private Exam $exam;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exam = Exam::factory()->create(['pass_mark' => 60]);

        foreach (['law' => [1, 2, 3, 4, 5], 'met' => [6, 7, 8, 9, 10]] as $position => $numbers) {
            $section = ExamSection::factory()->for($this->exam)->create(['key' => $position, 'name' => ucfirst($position)]);

            foreach ($numbers as $number) {
                Question::factory()->for($this->exam)->for($section, 'section')->create([
                    'number' => $number,
                    'correct_option' => 1,
                ]);
            }
        }
    }

    /**
     * @param  array<int, int>  $answers
     * @param  list<string>  $sections
     */
    private function submit(array $answers, array $sections = ['law', 'met'], array $flags = []): TestResponse
    {
        return $this->postJson(route('exams.attempts.store', $this->exam), [
            'sections' => $sections,
            'answers' => $answers,
            'flags' => $flags,
            'started_at' => now()->subMinutes(20)->getTimestampMs(),
        ]);
    }

    public function test_submitting_grades_and_stores_the_attempt(): void
    {
        // 4/5 in law, 3/5 in met (two wrong, question 10 left blank).
        $response = $this->submit([1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 2, 6 => 1, 7 => 1, 8 => 1, 9 => 4], flags: [9]);

        $response->assertCreated();
        $attempt = ExamAttempt::sole();
        $response->assertJson(['url' => route('attempts.show', $attempt)]);

        $this->assertSame(7, $attempt->correct_count);
        $this->assertSame(10, $attempt->question_count);
        $this->assertSame(70, $attempt->score);
        $this->assertTrue($attempt->passed);
        $this->assertSame([9], $attempt->flags);
        $this->assertSame([80, 60], array_column($attempt->section_results, 'score'));
    }

    public function test_failing_a_single_section_fails_the_attempt(): void
    {
        // 100% in law, 40% in met: 70% overall but met is below the pass mark.
        $this->submit([1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 1, 7 => 1])->assertCreated();

        $attempt = ExamAttempt::sole();
        $this->assertSame(70, $attempt->score);
        $this->assertFalse($attempt->passed);
    }

    public function test_only_chosen_sections_are_graded(): void
    {
        $this->submit([6 => 1, 7 => 1, 8 => 1], sections: ['met'])->assertCreated();

        $attempt = ExamAttempt::sole();
        $this->assertSame(['met'], $attempt->section_keys);
        $this->assertSame(5, $attempt->question_count);
        $this->assertSame(60, $attempt->score);
    }

    public function test_answers_to_unknown_questions_are_discarded(): void
    {
        $this->submit([1 => 1, 999 => 1])->assertCreated();

        $this->assertSame([1 => 1], ExamAttempt::sole()->answers);
    }

    public function test_invalid_submissions_are_rejected(): void
    {
        $this->submit([1 => 1], sections: ['nope'])->assertJsonValidationErrors('sections.0');
        $this->submit([1 => 7])->assertJsonValidationErrors('answers.1');
        $this->submit([], sections: [])->assertJsonValidationErrors('sections');

        $this->assertDatabaseCount('exam_attempts', 0);
    }

    public function test_results_page_shows_score_and_filters_review(): void
    {
        $this->submit([1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 1, 7 => 1, 8 => 1, 9 => 1, 10 => 2]);
        $attempt = ExamAttempt::sole();
        $wrong = $this->exam->questions()->firstWhere('number', 10);
        $right = $this->exam->questions()->firstWhere('number', 1);

        $this->get(route('attempts.show', $attempt))
            ->assertOk()
            ->assertSee('90%')
            ->assertSee('Cleared for take-off!')
            ->assertSee($wrong->stem)
            ->assertDontSee($right->stem);

        $this->get(route('attempts.show', ['attempt' => $attempt, 'filter' => 'right']))
            ->assertOk()
            ->assertSee($right->stem)
            ->assertDontSee($wrong->stem);
    }
}
