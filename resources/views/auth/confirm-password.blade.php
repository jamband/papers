<x-layout.main title="Confirm your password">
  <h1>Confirm your password</h1>
  <div class="mb-4 text-sm text-gray-600">
    This is a secure area of the application.
    Please confirm your password before continuing.
  </div>
  <form action="{{ route('password.confirm') }}" method="POST">
    @csrf
    <div class="mb-6">
      <label for="password">Password</label>
      <input id="password" type="password" name="password" />
      <x-form.error name="password" />
    </div>
    <x-button>Confirm</x-button>
  </form>
</x-layout.main>
