<x-layout.main title="Profile">
  <h1>Profile</h1>
  <div>Name: {{ $name }}</div>
  <div>Email: {{ $email }}</div>
  <hr class="my-10" />
  <a href="{{ route('auth.delete') }}">Delete account</a>
</x-layout.main>
