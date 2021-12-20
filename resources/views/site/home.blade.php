<x-layout.main title="">
  <h1>Home</h1>
  <x-auth.session-status :status="session('status')" class="mb-5" />
  <div class="mt-20 flex items-center justify-center">
    <a href="{{ route("paper.home") }}" class="px-5 py-2">Papers</a>
    @auth
      <a href="{{ route('profile') }}" class="px-5 py-2">Profile</a>
    @endauth
  </div>
  <hr class="my-10" />
  <div class="flex items-center justify-center">
    @auth
      <form action="{{ route('auth.logout') }}" method="POST">
        @csrf
        <x-button.link class="px-5 py-2" dusk="logout-button">
          Logout
        </x-button.link>
      </form>
    @else
      <a href="{{ route('auth.login') }}" class="px-5 py-2">Login</a>
      <a href="{{ route("auth.register") }}" class="px-5 py-2">Register</a>
    @endauth
  </div>
</x-layout.main>
