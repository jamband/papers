<x-layout.main title="{{ __('Forbidden') }}">
  <h1>{{ $title ?? __('Forbidden') }}</h1>
  <p>{{ $message ?? $exception->getMessage() }}</p>
  <div class="mt-20 text-center">
    <a href="{{ route('home') }}">Back to Home</a>
  </div>
</x-layout.main>
