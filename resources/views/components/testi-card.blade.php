@props(['quote' => '', 'name' => '', 'status' => '', 'image' => ''])

<div class="flex flex-col justify-between bg-white rounded-2xl shadow-sm h-full font-poppins overflow-hidden transition-all duration-300 hover:-translate-y-3 hover:shadow-lg cursor-pointer">
    <div class="p-6 md:p-8 pb-12 grow">
        <p class="text-ajeng-black text-[15px] md:text-base leading-relaxed font-medium">
            "{{ $quote }}"
        </p>
    </div>

    <div class="bg-ajeng-pink pt-3 pb-4 px-6 md:px-8 mt-auto relative flex items-center rounded-b-2xl">
        <div
            class="absolute -top-6 left-6 md:left-8 w-12 h-12 bg-gray-200 border-2 border-white rounded shadow-sm overflow-hidden shrink-0">
            <img src="{{ $image }}" alt="{{ $name }}" class="w-full h-full object-cover">
        </div>
        <div class="flex flex-col text-white ml-16 mt-1">
            <span class="font-semibold text-sm md:text-base">{{ $name }}</span>
            <span class="text-xs md:text-sm font-light opacity-90">{{ $status }}</span>
        </div>
    </div>
</div>
