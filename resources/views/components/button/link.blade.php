@props(['type' => 'submit', 'onclick' => '', 'dusk' => ''])

<button {{ $attributes->merge([
  'type' => $type,
  'class' => 'm-0 p-0 text-gray-700 bg-white underline decoration-[0.05em] underline-offset-[0.25em]',
  'onclick' => $onclick,
  'dusk' => $dusk,
]) }}>{{ $slot }}</button>
