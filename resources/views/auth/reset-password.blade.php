<x-layout.main title="Reset password">
  <h1>Reset password</h1>
  <form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="mb-5">
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{{ old('email', $email) }}">
      <x-form.error name="email" />
    </div>
    <div class="mb-5">
      <label for="password">Password</label>
      <input type="password" id="password" name="password">
      <x-form.error name="password" />
    </div>
    <div class="mb-10">
      <label for="password_confirmation">Confirm Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation">
    </div>
    <x-button>Reset Password</x-button>
  </form>
</x-layout.main>
