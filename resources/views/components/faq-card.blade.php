@props(['question' => '', 'answer' => ''])

<div
    class="faq-card-container bg-[#FCF5F7] p-6 md:p-8 rounded-2xl w-full cursor-pointer select-none transition-colors hover:bg-[#FAEDF0] font-poppins">
    <div class="flex justify-between items-center gap-4">
        <h3 class="font-bold text-lg md:text-xl text-black">
            {{ $question }}
        </h3>

        <div class="faq-icon transform transition-transform duration-300 ease-in-out">
            <x-heroicon-o-chevron-down class="w-6 h-6 stroke-[2.5px]" />
        </div>
    </div>

    <div class="faq-content grid transition-[grid-template-rows] duration-300 ease-in-out"
        style="grid-template-rows: 0fr;">
        <div class="overflow-hidden">
            <p class="pt-4 text-gray-700 text-[15px] md:text-base leading-relaxed pr-0 md:pr-12">
                {{ $answer }}
            </p>
        </div>
    </div>
</div>
