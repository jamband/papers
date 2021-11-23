<x-layout.main title="Update paper">
  <h1>Update paper</h1>
  <form action="{{ route('paper.update', [$paper]) }}" method="POST">
    @csrf
    <div class="mb-5">
      <label for="title" class="block">Title</label>
      <input type="text" name="title" id="title" value="{{ old('title', $paper->title) }}"/>
      <x-form.error name="title" />
    </div>
    <div class="mb-6">
      <label for="body" class="block">Body</label>
      <textarea name="body" id="body">{{ old('body', $paper->body) }}</textarea>
      <x-form.error name="body" />
    </div>
    <button type="submit" dusk="update-paper-button">
      Update
    </button>
  </form>
  <div class="mt-10 md:mt-20 text-center">
    <a href="{{ route('paper.home') }}">Back to Papers</a>
  </div>
</x-layout.main>
