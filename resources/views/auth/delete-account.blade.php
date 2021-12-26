<x-layout.main title="Delete your account">
  <h1>Delete your account</h1>
  <div class="mb-3 flex items-center text-red-600">
    <div class="mr-1">
      <x-icon.exclamation class="w-5 h-5" />
    </div>
    When the account is deleted, the related data will also be deleted.
  </div>
  <form action="{{ route('auth.delete') }}" method="POST">
    @csrf
    <x-button bg="bg-red-600" class="inline-flex items-center" onclick="return confirm('Are you sure you want to delete it?');">
      <span class="mr-1"><x-icon.exclamation class="w-5 h-5" /></span>
      Delete account
    </x-button>
    <span class="mx-1">or</span>
    <a href="{{ route('home') }}">Cancel</a>
  </form>
</x-layout.main>
