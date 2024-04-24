<x-layout.main title="Create new paper">
  <h1>Create new paper</h1>
  <form action="{{ route("paper.create") }}" method="POST">
    @csrf
    <div>
      <label for="title" class="block">Title</label>
      <input type="text" name="title" id="title" value="{{ old('title') }}"/>
      <x-form.error name="title" />
    </div>
    <div class="mt-5">
      <label for="body" class="block">Body</label>
      <textarea name="body" id="body">{{ old('body') }}</textarea>
      <x-form.error name="body" />
    </div>
    <x-button class="mt-6" dusk="create-paper-button">Create</x-button>
  </form>
  <div class="mt-10 md:mt-20 flex justify-center">
    <a href="{{ route("paper.home") }}">Back to Papers</a>
  </div>
</x-layout.main>
