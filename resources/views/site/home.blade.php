<x-layout.main title="">
  <h1>Home</h1>
  <x-auth.session-status />
  <div class="mt-20 flex items-center justify-center">
    <a href="{{ route("paper.home") }}" class="px-4 py-1">Papers</a>
    @auth
      <a href="{{ route('profile') }}" class="px-4 py-1">Profile</a>
    @endauth
  </div>
  <hr class="mt-10" />
  <div class="mt-10 flex items-center justify-center gap-3">
    @auth
      <form action="{{ route('auth.logout') }}" method="POST">
        @csrf
        <x-button.link class="px-4 py-1" dusk="logout-button">
          Logout
        </x-button.link>
      </form>
    @else
      <a href="{{ route('auth.login') }}" class="px-4 py-1">Login</a>
      <a href="{{ route("auth.register") }}" class="px-4 py-1">Register</a>
    @endauth
  </div>
</x-layout.main>
