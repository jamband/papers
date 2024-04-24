<x-layout.main title="Verify Email">
  <h1>Email Verification</h1>
  <div class="text-sm text-gray-600">
    Thanks for registered! Before getting started,
    could you verify your email address by clicking on the link
    we just emailed to you? If you didn't receive the email,
    we will gladly send you another.
  </div>
  @if (session('status') === 'verification-link-sent')
    <div class="mt-5 font-medium text-sm text-green-600">
      A new verification link has been sent to the email address
      you provided during registration.
    </div>
  @endif
  <form method="POST" action="{{ route('verification.send') }}" class="mt-5">
    @csrf
    <x-button>Resend Verification Email</x-button>
  </form>
  <hr class="mt-8" />
  <div class="flex items-center justify-center">
    <form action="{{ route('auth.logout') }}" method="POST" class="mt-8">
      @csrf
      <x-button.link class="px-4 py-1">Logout</x-button.link>
    </form>
  </div>
</x-layout.main>
