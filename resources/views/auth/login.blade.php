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
    <x-button>Login</x-button>
    <span class="mx-1">or</span>
    <a href="{{ route('password.forgot') }}">Forgot password?</a>
  </form>
  <hr class="my-10" />
  <a href="{{ route('admin.login') }}">Login as administrator</a>
  <div class="mt-2 flex items-center text-sm text-amber-500">
    <div class="mr-1">
      <x-icon.light-bulb class="w-5 h-5" />
    </div>
    This link usually does not exist.
    Displayed for development environment.
  </div>
</x-layout.main>
