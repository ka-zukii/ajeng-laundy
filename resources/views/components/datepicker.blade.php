@props(['name' => ''])

<div class="flex flex-col gap-1 w-full font-poppins">
    
    <input 
        type="date"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-3 border-2 border-ajeng-gray-3 rounded-4xl focus:outline-none focus:border-ajeng-pink focus:ring-1 focus:ring-ajeng-pink transition-all text-ajeng-black bg-ajeng-white cursor-pointer'
        ]) }}
    >

    @error($name)
        <span class="text-sm text-ajeng-bg-pink-2 font-medium ml-4">
            {{ $message }}
        </span>
    @enderror

</div>