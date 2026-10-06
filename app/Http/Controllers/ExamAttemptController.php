<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamAttemptRequest;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Support\ExamGrader;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ExamAttemptController extends Controller
{
    public function store(StoreExamAttemptRequest $request, Exam $exam, ExamGrader $grader): JsonResponse
    {
        abort_unless($exam->is_published, 404);

        $sectionKeys = $request->sectionKeys();
        $answers = $request->answers();

        $attempt = $exam->attempts()->create([
            ...$grader->grade($exam, $sectionKeys, $answers),
            'user_id' => $request->user()?->id,
            'session_id' => $request->session()->getId(),
            'section_keys' => $sectionKeys,
            'answers' => $answers,
            'flags' => $request->flags(),
            'started_at' => $request->startedAt(),
            'submitted_at' => now(),
        ]);

        return response()->json(['url' => route('attempts.show', $attempt)], 201);
    }

    public function show(ExamAttempt $attempt): View
    {
        $attempt->load('exam.sections.questions');

        $sections = $attempt->exam->sections->whereIn('key', $attempt->section_keys);

        return view('attempts.show', [
            'attempt' => $attempt,
            'exam' => $attempt->exam,
            'questions' => $sections->flatMap->questions->sortBy('number')->values(),
        ]);
    }
}
