@php /** @var App\Models\User[] $users */ @endphp
<x-layout.admin.main title="Manage Users">
  <h1>Manage Users</h1>
  <x-auth.session-status :status="session('status')" class="mb-5" />
  @foreach($users as $user)
    <div>Name: {{ $user->name }}</div>
    <div>Email: {{ $user->email }}</div>
    <div>Created at: {{ $user->created_at->format('F jS Y, g:i a') }}</div>
    <div class="mb-2">Updated at: {{ $user->updated_at->format('F jS Y, g:i a') }}</div>
    <form action="{{ route('user.delete', [$user]) }}" method="POST">
      @csrf
      <x-button onclick="return confirm('Are you sure you want to delete it?');" dusk="delete-user-button">
        Delete
      </x-button>
    </form>
    <hr class="mt-3 mb-10" />
  @endforeach
</x-layout.admin.main>
