@props(['title' => '', 'price' => 0, 'unit' => ''])

<div
    {{ $attributes->merge(['class' => 'bg-ajeng-pink p-6 md:p-8 rounded-[40px] flex flex-col gap-6 text-white w-full font-poppins shadow-sm transition-all duration-300 hover:-translate-y-3 hover:shadow-lg cursor-pointer']) }}>
    <div class="border-2 border-white rounded-full py-2 px-6 flex items-center justify-center">
        <h3 class="font-bold text-lg md:text-xl text-center">
            {{ $title }}
        </h3>
    </div>

    <div class="flex flex-col items-center justify-center my-4 gap-1">
        <span class="font-semibold text-lg">Biaya Layanan</span>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-4xl md:text-5xl">Rp {{ number_format($price, 0, ',', '.') }}</span>
        </div>

        <span class="text-md md:text-lg font-medium opacity-90 mt-1">
            per {{ $unit == 'kiloan' ? 'Kg' : 'Pcs' }}
        </span>
    </div>
</div>
