@php /** @var array<int, App\Groups\Papers\Paper> $papers */ @endphp
<x-layout.main title="">
  <h1>Papers</h1>
  <x-icon.pencil class="inline w-4 h-4 align-[-0.15rem]" />
  <a href="{{ route('paper.create') }}">Create new paper</a>
  <hr class="mt-10 text-gray-300" />
  @foreach ($papers as $paper)
    <section class="mt-10">
      <h2>{{ $paper->title }}</h2>
      <div class="mt-3">{{ $paper->body }}</div>
      <div class="mt-3 text-sm">
        <x-icon.clock class="inline w-4 h-4 align-[-0.15rem]" />
        {{ $paper->created_at }}
      </div>
      <div class="mt-1 flex gap-3">
        <a href="{{ route('paper.view', [$paper]) }}">Detail</a>
        <a href="{{ route('paper.update', [$paper]) }}">Update</a>
        <form action="{{ route('paper.delete', [$paper]) }}" method="POST">
          @csrf
          <x-button.link onclick="return confirm('Are you sure?');" dusk="delete-paper-button">
            Delete
          </x-button.link>
        </form>
      </div>
    </section>
    <hr class="mt-3 text-gray-300" />
  @endforeach
</x-layout.main>
