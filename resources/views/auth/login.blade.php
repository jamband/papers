<x-layout.main title="Login">
  <h1>Login</h1>
  <x-auth.session-status :status="session('status')" class="mb-5" />
  <form action="{{ route('auth.login') }}" method="POST">
    @csrf
    <div class="mb-5">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old("email") }}">
      <x-form.error name="email" />
    </div>
    <div class="mb-5">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="current-password">
      <x-form.error name="password" />
    </div>
    <div class="mb-6">
      <label for="remember_me">
        <input type="checkbox" id="remember_me" name="remember">
        <span class="ml-1 text-sm">Remember me</span>
      </label>
    </div>
    <button type="submit">Login</button>
    <span class="mx-1">or</span>
    <a href="{{ route('password.forgot') }}">Forgot password?</a>
  </form>
  <hr class="my-10" />
  <a href="{{ route('admin.login') }}">Login as administrator</a>
  <div class="mt-2 text-sm text-yellow-500">
    <x-icon.light-bulb class="w-5 h-5" />
    This link usually does not exist.
    Displayed for development environment.
  </div>
</x-layout.main>
