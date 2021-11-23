<x-layout.main title="Sign up">
  <h1>Register</h1>
  <form action="{{ route('auth.register') }}" method="POST">
    @csrf
    <div class="mb-5">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="{{ old('name') }}">
      <x-form.error name="name" />
    </div>
    <div class="mb-5">
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{{ old('email') }}">
      <x-form.error name="email" />
    </div>
    <div class="mb-5">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="new-password">
      <x-form.error name="password" />
    </div>
    <div class="mb-8">
      <label for="password_confirmation">Confirm Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation">
    </div>
    <button type="submit">Register</button>
  </form>
  <hr class="my-10" />
  <x-icon.light-bulb class="w-5 h-5" />
  If you have already registered as a user, please
  <a href="{{ route('auth.login') }}">Login from this link</a>.
</x-layout.main>
