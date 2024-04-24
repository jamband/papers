<x-layout.main title="{{ $paper->title }}">
  <section>
    <h1>{{ $paper->title }}</h1>
    <div>{{ $paper->body }}</div>
    <div class="mt-3">Created at: {{ $paper->created_at }}</div>
    <div>Updated at: {{ $paper->updated_at }}</div>
    <div class="flex gap-3">
      <a href="{{ route('paper.update', [$paper]) }}">Update</a>
      <form action="{{ route('paper.delete', [$paper]) }}" method="POST">
        @csrf
        <x-button.link onclick="return confirm('Are you sure?');">
          Delete
        </x-button.link>
      </form>
    </div>
  </section>
  <div class="mt-10 md:mt-20 flex justify-center">
    <a href="{{ route("paper.home") }}">Back to Papers</a>
  </div>
</x-layout.main>
