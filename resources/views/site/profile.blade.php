<x-layout.main title="Profile">
  <h1>Profile</h1>
  <section class="mb-10">
    <div>Name: {{ $name }}</div>
    <div>Email: {{ $email }}</div>
  </section>
  <hr class="mb-10" />
  <a href="{{ route('auth.delete') }}">Delete account</a>
</x-layout.main>
