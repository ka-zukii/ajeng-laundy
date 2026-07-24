@props(['name' => '', 'type' => 'text'])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-2.5 rounded-4xl focus:outline-none text-ajeng-black font-medium caret-ajeng-pink placeholder:text-ajeng-gray-2 placeholder:font-normal bg-ajeng-white'
    ]) }}
>