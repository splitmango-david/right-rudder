<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\ReferenceMaterial;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        return view('exams.index', [
            'exams' => Exam::published()->withCount('questions')->orderBy('title')->get(),
        ]);
    }

    public function show(Exam $exam): View
    {
        abort_unless($exam->is_published, 404);

        $exam->load(['sections.questions.referenceMaterials', 'referenceMaterials.images']);

        return view('exams.show', [
            'exam' => $exam,
            'examData' => [
                'slug' => $exam->slug,
                'reference' => $exam->reference,
                'externalChartNote' => $exam->external_chart_note,
                'submitUrl' => route('exams.attempts.store', $exam),
                'sections' => $exam->sections->map(fn ($section) => [
                    'id' => $section->key,
                    'name' => $section->name,
                    'short' => $section->short_name,
                    'questions' => $section->questions->pluck('number'),
                ]),
                // Correct answers are deliberately left out; grading happens on the server.
                'questions' => $exam->sections->flatMap->questions->map(fn (Question $question) => [
                    'n' => $question->number,
                    's' => $question->stem,
                    'o' => $question->options,
                    'r' => $question->referenceMaterials->pluck('key'),
                    'v' => $question->requires_external_chart,
                ])->values(),
                'refs' => $exam->referenceMaterials->mapWithKeys(fn (ReferenceMaterial $reference) => [
                    $reference->key => [
                        't' => $reference->title,
                        'pre' => $reference->text,
                        'imgs' => $reference->images->map(fn ($image) => [$image->label ?? '', $image->url()]),
                    ],
                ]),
            ],
        ]);
    }
}
