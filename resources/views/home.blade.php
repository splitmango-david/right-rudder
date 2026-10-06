@extends('layouts.app')

@section('content')
  <div class="home-cols">
    @if ($exams->isNotEmpty())
      <div class="exam-list">
      <h2 class="section-title">Practice exams</h2>
      @foreach ($exams as $exam)
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
      @endforeach
      </div>
    @endif

    @if ($guides)
      <div class="exam-list">
      <h2 class="section-title">Study guides</h2>
      @foreach ($guides as $slug => $guide)
        <section class="sheet intro">
          <span class="label">{{ $guide['category'] }}</span>
          <h2>{{ $guide['title'] }}</h2>
          <p>{{ $guide['summary'] }}</p>
          <div class="row">
            <a class="btn primary" href="{{ route('guides.show', $slug) }}">Open the guide →</a>
          </div>
        </section>
      @endforeach
      </div>
    @endif
  </div>
@endsection
