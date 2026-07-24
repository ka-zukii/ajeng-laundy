@props(['name' => '', 'placeholder' => 'Pilih Jam'])

<div class="flex flex-col gap-1 w-full font-poppins">
    <input type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' =>
                'ajeng-timepicker w-full px-4 py-2.5 rounded-4xl focus:outline-none text-ajeng-black placeholder:text-ajeng-gray-2 placeholder:font-normal bg-ajeng-white cursor-pointer',
        ]) }}>

    @error($name)
        <span class="text-sm text-ajeng-bg-pink-2 font-medium ml-4">
            {{ $message }}
        </span>
    @enderror
</div>
