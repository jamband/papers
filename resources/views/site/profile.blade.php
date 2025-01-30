<x-layout.main title="Profile">
  <h1>Profile</h1>
  <div>
    <div>Name: {{ $name }}</div>
    <div>Email: {{ $email }}</div>
  </div>
  <hr class="mt-10 text-gray-300" />
  <div class="mt-10">
    <a href="{{ route('auth.delete') }}" class="mt-10">Delete account</a>
  </div>
</x-layout.main>
