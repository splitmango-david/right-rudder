@php
    $filters = ['wrong' => 'Wrong or blank', 'right' => 'Correct', 'flag' => 'Flagged', 'all' => 'All'];
    $filter = array_key_exists(request('filter'), $filters) ? request('filter') : 'wrong';
    $elapsed = (int) $attempt->started_at->diffInSeconds($attempt->submitted_at);
    $elapsedLabel = $elapsed >= 3600
        ? sprintf('%d:%02d:%02d', intdiv($elapsed, 3600), intdiv($elapsed % 3600, 60), $elapsed % 60)
        : sprintf('%d:%02d', intdiv($elapsed, 60), $elapsed % 60);
    $visibleQuestions = $questions->filter(fn ($question) => match ($filter) {
        'wrong' => $attempt->answerFor($question->number) !== $question->correct_option,
        'right' => $attempt->answerFor($question->number) === $question->correct_option,
        'flag' => $attempt->isFlagged($question->number),
        default => true,
    });
@endphp

@extends('layouts.app', ['title' => "Results · {$exam->title}", 'heading' => $exam->title, 'meta' => "Finished in {$elapsedLabel}"])

@section('content')
  <section class="sheet">
    <span class="label">Results</span>
    <div class="score" style="margin-top:8px">
      <div @class(['big', 'low' => ! $attempt->passed])>{{ $attempt->score }}%</div>
      <div>
        <div style="font-size:18px"><b>{{ $attempt->correct_count }}</b> of {{ $attempt->question_count }} correct</div>
        <span @class(['verdict', 'pass' => $attempt->passed, 'fail' => ! $attempt->passed])>{{ $attempt->passed ? 'Cleared for take-off!' : 'Go around and try again' }}</span>
        <div class="note" style="margin-top:6px">{{ $exam->pass_mark }}% overall and in every section is needed to pass.</div>
      </div>
    </div>
    <table class="sectbl">
      <thead><tr><th>Section</th><th style="text-align:right">Correct</th><th style="text-align:right">Score</th><th></th></tr></thead>
      <tbody>
        @foreach ($attempt->section_results as $result)
          <tr>
            <td>{{ $result['name'] }}</td>
            <td class="n">{{ $result['correct'] }} / {{ $result['total'] }}</td>
            <td class="n">{{ $result['score'] }}%</td>
            <td><span @class(['verdict', 'pass' => $result['passed'], 'fail' => ! $result['passed']])>{{ $result['passed'] ? 'Pass' : "Below {$exam->pass_mark}%" }}</span></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="row" style="margin-top:18px">
      <a class="btn primary" href="{{ route('exams.show', ['exam' => $exam, 'retake' => implode(',', $attempt->section_keys)]) }}">Take it again</a>
      <a class="btn" href="{{ route('exams.show', $exam) }}">Change sections</a>
    </div>
  </section>

  <section class="review" id="review">
    <h2 style="font-size:22px;margin-top:8px">Review answers</h2>
    <div class="filters">
      @foreach ($filters as $key => $label)
        <a href="{{ request()->fullUrlWithQuery(['filter' => $key]) }}#review" @class(['on' => $filter === $key])>{{ $label }}</a>
      @endforeach
    </div>
    @forelse ($visibleQuestions as $question)
      @php
          $chosen = $attempt->answerFor($question->number);
          $isCorrect = $chosen === $question->correct_option;
      @endphp
      <article @class(['ritem', 'right' => $isCorrect, 'wrong' => ! $isCorrect])>
        {{-- Stems are trusted seed content and may contain formatting markup. --}}
        <p class="q"><span class="n">Q{{ $question->number }}</span>{!! $question->stem !!}</p>
        <ol>
          @foreach ($question->options as $index => $option)
            @php($optionNumber = $index + 1)
            <li @class(['c' => $optionNumber === $question->correct_option, 'x' => $optionNumber === $chosen && ! $isCorrect])>({{ $optionNumber }}) {{ $option }}@if ($optionNumber === $question->correct_option) ✓@endif</li>
          @endforeach
        </ol>
        <div class="tag" style="margin-top:6px">{{ $chosen === null ? 'Not answered' : ($isCorrect ? 'Your answer: correct' : "Your answer: ({$chosen})") }}@if ($attempt->isFlagged($question->number)) · Flagged @endif</div>
      </article>
    @empty
      <p class="note">Nothing in this view.</p>
    @endforelse
  </section>
@endsection
