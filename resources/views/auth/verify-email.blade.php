<x-layout.main title="Verify Email">
  <h1>Email Verification</h1>
  <div class="mb-4 text-sm text-gray-600">
    Thanks for registered! Before getting started,
    could you verify your email address by clicking on the link
    we just emailed to you? If you didn't receive the email,
    we will gladly send you another.
  </div>
  @if (session('status') === 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600">
      A new verification link has been sent to the email address
      you provided during registration.
    </div>
  @endif
  <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <x-button>Resend Verification Email</x-button>
  </form>
  <hr class="my-10" />
  <div class="flex items-center justify-center">
    <form action="{{ route('auth.logout') }}" method="POST">
      @csrf
      <x-button.link class="px-5 py-2">Logout</x-button.link>
    </form>
  </div>
</x-layout.main>
