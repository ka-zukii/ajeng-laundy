@props(['name' => ''])

<div class="flex flex-col gap-1 w-full font-poppins">

    <div class="relative">
        <select name="{{ $name }}" id="{{ $name }}"
            {{ $attributes->merge([
                'class' =>
                    'w-full px-4 py-2.5 pr-10 rounded-4xl focus:outline-none text-ajeng-black bg-ajeng-white cursor-pointer appearance-none',
            ]) }}>
            {{ $slot }}
        </select>

        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-ajeng-gray-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>

    @error($name)
        <span class="text-sm text-ajeng-bg-pink-2 font-medium ml-4">
            {{ $message }}
        </span>
    @enderror

</div>
