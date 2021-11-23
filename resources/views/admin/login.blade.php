<x-layout.admin.main title="Login as administrator">
  <h1>
    Login
    <span class="text-base text-gray-600">as administrator</span>
  </h1>
  <form action="{{ route('admin.login') }}" method="POST">
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
    <span class="ml-1">as administrator</span>
  </form>
  <hr class="my-10" />
  <a href="{{ route('auth.login') }}">Login as regular user</a>
  <div class="mt-2 text-sm text-yellow-500">
    <x-icon.light-bulb class="w-5 h-5" />
    This is a login link for regular users.
  </div>
</x-layout.admin.main>
