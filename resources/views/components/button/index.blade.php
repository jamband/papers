@props([
  'type' => 'submit',
  'bg' => 'bg-gray-600',
  'onclick' => '',
  'dusk' => '',
])
<button {{ $attributes->merge([
  'type' => $type,
  'class' => 'px-4 py-1 text-gray-200 rounded shadow-sm '.$bg,
  'onclick' => $onclick,
  'dusk' => $dusk
]) }}>{{ $slot }}</button>
