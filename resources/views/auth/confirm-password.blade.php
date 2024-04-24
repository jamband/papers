<x-layout.main title="Confirm your password">
  <h1>Confirm your password</h1>
  <div class="text-sm text-gray-600">
    This is a secure area of the application.
    Please confirm your password before continuing.
  </div>
  <form action="{{ route('password.confirm') }}" method="POST" class="mt-4">
    @csrf
    <div>
      <label for="password">Password</label>
      <input id="password" type="password" name="password" />
      <x-form.error name="password" />
    </div>
    <x-button class="mt-6">Confirm</x-button>
  </form>
</x-layout.main>
