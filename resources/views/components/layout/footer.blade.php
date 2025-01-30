<footer class="bg-gray-100">
  <nav class="py-3 flex items-center justify-center gap-3 text-sm" aria-label="Footer navigation">
    <a href="{{ route('about') }}" class="px-4 py-1 no-underline active:bg-gray-200 active:text-gray-600 hover:bg-gray-200 hover:text-gray-600 rounded">About</a>
    <a href="{{ route('contact') }}" class="px-4 py-1 no-underline active:bg-gray-200 active:text-gray-600 hover:bg-gray-200 hover:text-gray-600 rounded">Contact</a>
    <x-link.external href="https://github.com/jamband/papers" class="px-4 py-1 no-underline active:bg-gray-200 active:text-gray-600 hover:bg-gray-200 hover:text-gray-600 rounded">GitHub</x-link.external>
  </nav>
</footer>
