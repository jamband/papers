@error($name)
  <div class="py-0.5 font-light text-red-400 {{ $attributes->get('class') }}">
    {{ $message }}
  </div>
@enderror
