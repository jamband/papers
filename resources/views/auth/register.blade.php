<x-layout.main title="Sign up">
  <h1>Register</h1>
  <form action="{{ route('auth.register') }}" method="POST">
    @csrf
    <div>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="{{ old('name') }}">
      <x-form.error name="name" />
    </div>
    <div class="mt-5">
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{{ old('email') }}">
      <x-form.error name="email" />
    </div>
    <div class="mt-5">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="new-password">
      <x-form.error name="password" />
    </div>
    <div class="mt-5">
      <label for="password_confirmation">Confirm Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation">
    </div>
    <x-button class="mt-8">Register</x-button>
  </form>
  <hr class="mt-8" />
  <p class="mt-8">
    <x-icon.light-bulb class="inline w-4 h-4 align-[-0.1em]" />
    If you have already registered as a user, please
    <a href="{{ route('auth.login') }}">Login from this link</a>.
  </p>
</x-layout.main>
