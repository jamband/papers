@session('status')
  <div class="font-medium text-sm text-green-600 {{ $attributes->get('class') }}">
    {{ $value }}
  </div>
@endsession
