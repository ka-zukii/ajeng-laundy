@props(['name' => '', 'type' => 'text'])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
    {{ $attributes->merge([
        'class' => 'w-full px-4 py-2.5 border-2 border-ajeng-gray-3 rounded-4xl focus:outline-none focus:border-ajeng-pink focus:ring-2 focus:ring-ajeng-pink transition-all text-ajeng-black font-medium caret-ajeng-pink placeholder:text-ajeng-gray-2 placeholder:font-normal bg-ajeng-white'
    ]) }}
>