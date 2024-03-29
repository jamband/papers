<x-layout.main title="Create new paper">
  <h1>Create new paper</h1>
  <form action="{{ route("paper.create") }}" method="POST" class="mb-10 md:mb-20">
    @csrf
    <div class="mb-5">
      <label for="title" class="block">Title</label>
      <input type="text" name="title" id="title" value="{{ old('title') }}"/>
      <x-form.error name="title" />
    </div>
    <div class="mb-6">
      <label for="body" class="block">Body</label>
      <textarea name="body" id="body">{{ old('body') }}</textarea>
      <x-form.error name="body" />
    </div>
    <x-button dusk="create-paper-button">Create</x-button>
  </form>
  <div class="text-center">
    <a href="{{ route("paper.home") }}">Back to Papers</a>
  </div>
</x-layout.main>
