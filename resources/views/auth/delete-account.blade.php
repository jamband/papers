<x-layout.main title="Delete your account">
  <h1>Delete your account</h1>
  <p class="text-red-600">
    <x-icon.exclamation class="w-5 h-5" />
    When the account is deleted, the related data will also be deleted.
  </p>
  <form action="{{ route('auth.delete') }}" method="POST">
    @csrf
    <button type="submit" class="bg-red-600" onclick="return confirm('Are you sure you want to delete it?');">
      <x-icon.exclamation class="w-5 h-5" />
      Delete account
    </button>
    <span class="mx-1">or</span>
    <a href="{{ route('home') }}">Cancel</a>
  </form>
</x-layout.main>
