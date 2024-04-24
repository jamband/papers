<x-layout.admin.main title="Admin Home">
  <h1>Admin Home</h1>
  <x-auth.session-status />
  <div class="mt-20 flex items-center justify-center">
    <a href="{{ route('admin.users') }}" class="px-4 py-1">Users</a>
  </div>
  <hr class="mt-10" />
  <div class="mt-10 flex items-center justify-center">
    <form action="{{ route('admin.logout') }}" method="POST">
      @csrf
      <x-button.link class="px-4 py-1">Logout</x-button.link>
    </form>
  </div>
</x-layout.admin.main>
