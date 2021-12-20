<x-layout.main title="{{ $paper->title }}">
  <h1 class="mb-3">{{ $paper->title }}</h1>
  <div class="mb-3">{{ $paper->body }}</div>
  <div>Created at: {{ $paper->created_at }}</div>
  <div>Updated at: {{ $paper->updated_at }}</div>
  <a href="{{ route('paper.update', [$paper]) }}" class="mr-2">Update</a>
  <form action="{{ route('paper.delete', [$paper]) }}" method="POST" class="inline">
    @csrf
    <x-button.link onclick="return confirm('Are you sure?');">
      Delete
    </x-button.link>
  </form>
  <div class="mt-10 md:mt-20 text-center">
    <a href="{{ route("paper.home") }}">Back to Papers</a>
  </div>
</x-layout.main>
