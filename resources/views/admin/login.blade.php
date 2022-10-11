<x-layout.admin.main title="Login as administrator">
  <h1>
    Login
    <span class="text-base text-gray-600">as administrator</span>
  </h1>
  <form action="{{ route('admin.login') }}" method="POST" class="mb-10">
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
    <span class="ml-1">as administrator</span>
  </form>
  <hr class="mb-10" />
  <div class="mb-2">
    <a href="{{ route('auth.login') }}">Login as regular user</a>
  </div>
  <p class="text-sm text-amber-500">
    <x-icon.light-bulb class="w-4 h-4 align-[-0.125em]" />
    This is a login link for regular users.
  </p>
</x-layout.admin.main>
