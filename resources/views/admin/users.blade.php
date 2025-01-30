@php /** @var array<int, App\Groups\Users\User> $users */ @endphp
<x-layout.admin.main title="Manage Users">
  <h1>Manage Users</h1>
  <x-auth.session-status />
  @foreach($users as $user)
    <div class="mt-10 flex flex-col">
      <div>Name: {{ $user->name }}</div>
      <div>Email: {{ $user->email }}</div>
      <div class="mt-1">Created at: {{ $user->created_at->format('F jS Y, g:i a') }}</div>
      <div>Updated at: {{ $user->updated_at->format('F jS Y, g:i a') }}</div>
      <form action="{{ route('admin.user.delete', [$user]) }}" method="POST" class="mt-3">
        @csrf
        <x-button onclick="return confirm('Are you sure you want to delete it?');" dusk="delete-user-button">
          Delete
        </x-button>
      </form>
      <hr class="mt-3 text-gray-300" />
    </div>
  @endforeach
</x-layout.admin.main>
