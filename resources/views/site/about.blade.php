<x-layout.main title="About">
  <h1>About</h1>
  <p>
    {{ config('app.name') }} is my private playground for Authentication with Laravel.
  </p>
  <p>
    This website is an open source project. See
    <x-link.external href="https://github.com/jamband/papers">
      GitHub jamband/papers<x-icon.external-link class="w-5 h-5" />
    </x-link.external>
    for details.
  </p>
</x-layout.main>
