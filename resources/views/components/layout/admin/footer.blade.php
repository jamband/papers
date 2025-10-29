<footer class="p-4 text-center bg-gray-100">
  @auth('admin')
    <div class="font-semibold">
      <x-icon.light-bulb class="inline w-5 h-5 align-[-0.15rem] text-amber-400" />
      Currently logged in as an administrator
    </div>
  @else
    <nav class="text-sm" aria-label="Footer navigation">
      <x-link.external href="https://github.com/jamband/papers" class="px-4 py-1.5 no-underline active:bg-gray-200 active:text-gray-600 hover:bg-gray-200 hover:text-gray-600 rounded">GitHub</x-link.external>
    </nav>
  @endauth
</footer>
