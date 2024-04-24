<x-layout.main title="Forgot password">
  <h1>Forgot password</h1>
  <p class="text-sm">
    Forgot your password? No problem.
    Just let us know your email address and we will email you
    a password reset link that will allow you to choose a new one.
  </p>
  <x-auth.session-status />
  <form action="{{ route('password.forgot') }}" method="POST" class="mt-5">
    @csrf
    <div>
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{{ old('email') }}">
      <x-form.error name="email" />
    </div>
    <x-button class="mt-8">Send Email</x-button>
  </form>
</x-layout.main>
