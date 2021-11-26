<footer class="py-4 text-center bg-gray-100">
  @auth('admin')
    <div class="font-bold">
      <x-icon.light-bulb class="w-5 h-5 text-yellow-400" />
      Currently logged in as an administrator
    </div>
  @else
    <nav class="text-sm" aria-label="Footer navigation">
      <x-link.external href="https://github.com/jamband/papers" class="p-3">GitHub</x-link.external>
    </nav>
  @endauth
</footer>