<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ? $title.' ･ '.config('app.name') : config('app.name') }}</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
<div class="flex flex-col min-h-screen">
  <x-layout.header></x-layout.header>
  <main class="flex-grow container mx-auto pt-28 pb-10">
    {{ $slot }}
  </main>
  <x-layout.footer></x-layout.footer>
</div>
</body>
</html>
