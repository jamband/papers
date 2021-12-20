@php /** @var App\Models\Paper[] $papers */ @endphp
<x-layout.main title="">
  <h1>Papers</h1>
  <div class="my-5">
    <a href="{{ route('paper.create') }}">
      <x-icon.pencil class="w-5 h-5" />
      Create new paper
    </a>
  </div>
  <hr class="my-10" />
  @foreach ($papers as $paper)
    <h2 class="mb-3">{{ $paper->title }}</h2>
    <div class="mb-3">{{ $paper->body }}</div>
    <div class="mb-1">
      <x-icon.clock class="w-5 h-5" />
      {{ $paper->created_at }}
    </div>
    <a href="{{ route('paper.view', [$paper]) }}" class="mr-2">Detail</a>
    <a href="{{ route('paper.update', [$paper]) }}" class="mr-2">Update</a>
    <form action="{{ route('paper.delete', [$paper]) }}" method="POST" class="inline">
      @csrf
      <x-button.link onclick="return confirm('Are you sure?');" dusk="delete-paper-button">
        Delete
      </x-button.link>
    </form>
    <hr class="mt-3 mb-10" />
  @endforeach
</x-layout.main>
