<footer class="py-4 text-center bg-gray-100">
  @auth('admin')
    <div class="text-center font-bold">
      <x-icon.light-bulb class="w-5 h-5 align-[-0.2em] text-amber-400" />
      Currently logged in as an administrator
    </div>
  @else
    <nav class="text-sm" aria-label="Footer navigation">
      <x-link.external href="https://github.com/jamband/papers" class="p-3 no-underline hover:bg-gray-200 rounded">GitHub</x-link.external>
    </nav>
  @endauth
</footer>
