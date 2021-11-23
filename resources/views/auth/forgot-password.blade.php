<x-layout.main title="Forgot password">
  <h1>Forgot password</h1>
  <p class="text-sm">
    Forgot your password? No problem.
    Just let us know your email address and we will email you
    a password reset link that will allow you to choose a new one.
  </p>
  <x-auth.session-status :status="session('status')" class="mb-5" />
  <form action="{{ route('password.forgot') }}" method="POST">
    @csrf
    <div class="mb-8">
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{{ old('email') }}">
      <x-form.error name="email" />
    </div>
    <button type="submit">Send Email</button>
  </form>
</x-layout.main>
