@if ($status)
  <div class="font-medium text-sm text-green-600 {{ $attributes->get('class') }}">
    {{ $status }}
  </div>
@endif
