@extends('layouts.app')

@section('content')
  <div class="exam-list">
    @forelse ($exams as $exam)
      <section class="sheet intro">
        <span class="label">{{ $exam->category }}</span>
        <h2>{{ $exam->heading }}</h2>
        @if ($exam->description)
          <p>{{ $exam->description }}</p>
        @endif
        <p class="note">{{ $exam->questions_count }} questions · {{ $exam->pass_mark }}% to pass @if ($exam->reference) · {{ $exam->reference }} @endif</p>
        <div class="row">
          <a class="btn primary" href="{{ route('exams.show', $exam) }}">{{ $exam->title }} →</a>
        </div>
      </section>
    @empty
      <section class="sheet"><p class="note">No exams yet.</p></section>
    @endforelse
  </div>
@endsection
