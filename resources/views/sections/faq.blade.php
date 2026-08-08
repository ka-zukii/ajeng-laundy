@php
    $faqs = [
        [
            'q' => 'Apakah Ajeng Laundry menerima semua jenis pakaian?',
            'a' =>
                'Kami menerima berbagai jenis pakaian dan kain. Namun, untuk bahan tertentu yang memerlukan perawatan khusus, akan dilakukan penanganan sesuai prosedur yang tepat.',
        ],
        [
            'q' => 'Apakah pakaian saya akan tercampur dengan milik pelanggan lain?',
            'a' =>
                'Tentu saja tidak. Kami mencuci setiap pesanan pelanggan secara terpisah untuk menjaga kebersihan dan menghindari risiko warna luntur atau tertukar.',
        ],
        [
            'q' => 'Bagaimana jika pakaian saya rusak atau hilang?',
            'a' =>
                'Kami selalu mengutamakan keamanan dan kualitas layanan. Jika terjadi kendala, pelanggan dapat segera menghubungi kami agar dapat ditindaklanjuti sesuai kebijakan yang berlaku.',
        ],
        [
            'q' => 'Apakah ada minimal berat untuk laundry kiloan?',
            'a' =>
                'Ya, untuk layanan laundry kiloan minimal berat adalah 3 Kg. Jika cucian Anda kurang dari itu, akan tetap dihitung seharga 3 Kg.',
        ],
    ];
@endphp

<section id="faq" class="w-full px-6 md:px-8 py-16 md:py-24 bg-white font-poppins flex justify-center">

    <div class="max-w-3xl w-full flex flex-col gap-6 md:gap-8">

        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center mb-4 md:mb-6 tracking-tight">
            FAQ
        </h2>

        <div class="flex flex-col gap-4 md:gap-5">
            @foreach ($faqs as $faq)
                <x-faq-card question="{{ $faq['q'] }}" answer="{{ $faq['a'] }}" />
            @endforeach
        </div>

    </div>
</section>
