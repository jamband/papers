<x-layout.main title="Delete your account">
  <h1>Delete your account</h1>
  <div class="text-red-600">
    <x-icon.exclamation class="inline w-5 h-5 align-[-0.3em]" />
    When the account is deleted, the related data will also be deleted.
  </div>
  <form action="{{ route('auth.delete') }}" method="POST" class="mt-3">
    @csrf
    <x-button bg="bg-red-600" onclick="return confirm('Are you sure you want to delete it?');">
      <x-icon.exclamation class="inline w-5 h-5 align-[-0.25em]" />
      Delete account
    </x-button>
    <span class="mx-1">or</span>
    <a href="{{ route('home') }}">Cancel</a>
  </form>
</x-layout.main>
