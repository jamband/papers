<x-layout.main title="Update paper">
  <h1>Update paper</h1>
  <form action="{{ route('paper.update', [$paper]) }}" method="POST">
    @csrf
    <div>
      <label for="title" class="block">Title</label>
      <input type="text" name="title" id="title" value="{{ old('title', $paper->title) }}"/>
      <x-form.error name="title" />
    </div>
    <div class="mt-5">
      <label for="body" class="block">Body</label>
      <textarea name="body" id="body">{{ old('body', $paper->body) }}</textarea>
      <x-form.error name="body" />
    </div>
    <x-button class="mt-6" dusk="update-paper-button">Update</x-button>
  </form>
  <div class="mt-10 md:mt-20 flex justify-center">
    <a href="{{ route('paper.home') }}">Back to Papers</a>
  </div>
</x-layout.main>
