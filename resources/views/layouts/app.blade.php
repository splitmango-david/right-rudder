<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? config('app.name') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Nunito:ital,wght@0,500;0,700;0,800;1,500&family=Space+Mono:wght@400;700&display=swap">
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('head')
</head>
<body>

<div class="wrap">
  <header class="top">
    <a class="brand" href="{{ route('home') }}">
      <x-brand-plane />
      <h1>{{ $heading ?? config('app.name') }}</h1>
    </a>
    <span class="meta" id="meta">{{ $meta ?? '' }}</span>
  </header>

  <main id="app">
    @yield('content')
  </main>
</div>

@stack('body')
</body>
</html>
