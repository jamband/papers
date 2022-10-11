@php /** @var App\Models\Paper[] $papers */ @endphp
<x-layout.main title="">
  <h1>Papers</h1>
  <div class="mb-10">
    <x-icon.pencil class="w-4 h-4 align-[-0.125em]" />
    <a href="{{ route('paper.create') }}">Create new paper</a>
  </div>
  <hr class="mb-10" />
  @foreach ($papers as $paper)
    <section class="mb-3">
      <h2 class="mb-3">{{ $paper->title }}</h2>
      <div class="mb-3">{{ $paper->body }}</div>
      <div class="mb-1 text-sm">
        <x-icon.clock class="w-4 h-4 align-[-0.17em]" />
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
    </section>
    <hr class="mb-10" />
  @endforeach
</x-layout.main>
