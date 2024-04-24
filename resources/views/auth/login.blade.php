<x-layout.main title="Login">
  <h1>Login</h1>
  <x-auth.session-status />
  <form action="{{ route('auth.login') }}" method="POST" class="mt-5">
    @csrf
    <div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old("email") }}">
      <x-form.error name="email" />
    </div>
    <div class="mt-5">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="current-password">
      <x-form.error name="password" />
    </div>
    <div class="mt-6">
      <label for="remember_me">
        <input type="checkbox" id="remember_me" name="remember">
        <span class="ml-1 text-sm">Remember me</span>
      </label>
    </div>
    <x-button class="mt-6">Login</x-button>
    <span class="mx-1">or</span>
    <a href="{{ route('password.forgot') }}">Forgot password?</a>
  </form>
  <hr class="mt-10"/>
  <div class="mt-10">
    <a href="{{ route('admin.login') }}">Login as administrator</a>
  </div>
  <p class="mt-2 text-sm text-amber-500">
    <x-icon.light-bulb class="inline w-4 h-4 align-[-0.125em]" />
    This link usually does not exist.
    Displayed for development environment.
  </p>
</x-layout.main>
