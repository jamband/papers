<button type="{{ $type }}" class="m-0 p-0 text-gray-700 bg-white underline {{ $attributes->get('class') }}" style="text-decoration-thickness: 0.05em; text-underline-offset: 0.25em" onclick="{{ $attributes->get('onclick') }}" dusk="{{ $attributes->get('dusk') }}">{{ $slot }}</button>