<?php

namespace App\Support;

use App\Models\Exam;

class ExamGrader
{
    /**
     * Grade a set of answers against the chosen sections of an exam.
     *
     * A pass needs the exam's pass mark overall and in every section taken.
     * Unanswered questions count as wrong.
     *
     * @param  list<string>  $sectionKeys
     * @param  array<int, int>  $answers  Question number => chosen option (1-based)
     * @return array{
     *     section_results: list<array{key: string, name: string, correct: int, total: int, score: int, passed: bool}>,
     *     correct_count: int,
     *     question_count: int,
     *     score: int,
     *     passed: bool,
     * }
     */
    public function grade(Exam $exam, array $sectionKeys, array $answers): array
    {
        $exam->loadMissing('sections.questions');

        $sectionResults = $exam->sections
            ->whereIn('key', $sectionKeys)
            ->map(function ($section) use ($answers, $exam) {
                $total = $section->questions->count();
                $correct = $section->questions
                    ->filter(fn ($question) => ($answers[$question->number] ?? null) === $question->correct_option)
                    ->count();
                $score = $total > 0 ? (int) round($correct / $total * 100) : 0;

                return [
                    'key' => $section->key,
                    'name' => $section->name,
                    'correct' => $correct,
                    'total' => $total,
                    'score' => $score,
                    'passed' => $score >= $exam->pass_mark,
                ];
            })
            ->values();

        $correctCount = $sectionResults->sum('correct');
        $questionCount = $sectionResults->sum('total');
        $score = $questionCount > 0 ? (int) round($correctCount / $questionCount * 100) : 0;

        return [
            'section_results' => $sectionResults->all(),
            'correct_count' => $correctCount,
            'question_count' => $questionCount,
            'score' => $score,
            'passed' => $score >= $exam->pass_mark && $sectionResults->every('passed'),
        ];
    }
}
