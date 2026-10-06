@extends('layouts.app', ['title' => $exam->title, 'heading' => $exam->title, 'meta' => $exam->reference])

@push('head')
  @vite('resources/js/exam.js')
@endpush

@section('content')
  <section class="sheet intro" id="start">
    <span class="label">{{ $exam->category }}</span>
    <h2 style="font-size:30px;margin:6px 0 12px">{{ $exam->heading }}</h2>
    @if ($exam->description)
      <p>{{ $exam->description }}</p>
    @endif
    @if ($exam->notes)
      <p class="note">{{ $exam->notes }}</p>
    @endif
    <div class="sec-pick" role="group" aria-label="Sections to include">
      @foreach ($exam->sections as $section)
        <label>
          <input type="checkbox" id="pick-{{ $section->key }}" value="{{ $section->key }}" checked>
          <span><b>{{ $section->name }}</b><small>{{ $section->questions->count() }} questions · Q{{ $section->questions->min('number') }}–{{ $section->questions->max('number') }}</small></span>
        </label>
      @endforeach
    </div>
    <div class="row">
      <button class="btn primary" id="go">Start exam</button>
      <button class="btn" id="resume" hidden></button>
      <a class="btn" id="last-results" hidden>View your last results</a>
    </div>
    <p class="note" id="pickErr" hidden style="color:var(--bad)">Pick at least one section to start.</p>
  </section>
@endsection

@push('body')
<div class="dock" id="dock" hidden><div class="wrap">
  <div class="grp"><button class="btn" id="prev">← Prev</button><button class="btn flag" id="flag" aria-pressed="false">Flag</button></div>
  <div class="grp"><button class="btn" id="finish">Finish exam</button><button class="btn primary" id="next">Next →</button></div>
</div></div>
<div class="lb" id="lb" hidden><img id="lbimg" alt=""></div>
<script type="application/json" id="exam-data">@json($examData)</script>
@endpush
