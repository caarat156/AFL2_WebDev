<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
{{-- Ini mirip dengan tombol sebelumnya, 
tapi ini component untuk <a> (link) di Laravel Blade, biasanya dipakai di dropdown, menu, atau navigasi. --}}