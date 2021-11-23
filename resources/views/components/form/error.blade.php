@error($name)
  <div class="py-1 font-light text-sm text-red-400 {{ $attributes->get('class') }}">
    {{ $message }}
  </div>
@enderror
