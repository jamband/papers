<x-layout.admin.main title="Admin Home">
  <h1>Admin Home</h1>
  <x-auth.session-status :status="session('status')" class="mb-5" />
  <div class="mb-20"></div>
  <div class="mb-10 flex items-center justify-center">
    <a href="{{ route('admin.users') }}" class="px-5 py-2">Users</a>
  </div>
  <hr class="mb-10" />
  <div class="flex items-center justify-center">
    <form action="{{ route('admin.logout') }}" method="POST">
      @csrf
      <x-button.link class="px-5 py-2">Logout</x-button.link>
    </form>
  </div>
</x-layout.admin.main>
