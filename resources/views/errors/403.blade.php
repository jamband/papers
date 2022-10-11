<x-layout.main title="{{ __('Forbidden') }}">
  <h1>{{ $title ?? __('Forbidden') }}</h1>
  <p class="mb-20">{{ $message ?? $exception->getMessage() }}</p>
  <div class="text-center">
    <a href="{{ route('home') }}">Back to Home</a>
  </div>
</x-layout.main>
