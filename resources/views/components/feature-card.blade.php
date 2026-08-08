@props(['title' => '', 'desc' => ''])

<div class="flex flex-col gap-4 font-poppins">
    <div class="w-14 h-14 bg-ajeng-pink rounded-full shrink-0 flex items-center justify-center text-white">
        {{ $icon }}
    </div>

    <div class="flex flex-col gap-2">
        <h3 class="text-ajeng-black font-bold text-lg md:text-xl leading-snug">
            {{ $title }}
        </h3>

        <p class="text-ajeng-dark-2 text-[15px] md:text-base leading-relaxed pr-0 md:pr-4">
            {{ $desc }}
        </p>
    </div>
</div>
