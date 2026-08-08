@php
    $testimonials = [
        [
            'quote' => 'Pelayanan super cepat, aman, dan terpercaya.',
            'name' => 'Anang Setiaji',
            'status' => 'Pelanggan Setia',
            'image' => '/assets/testimonial-images/anang.jpeg',
        ],
        [
            'quote' =>
                'Cepat, tepat, wangi, rapi, dan ada delivery servicenya. Ada Ajeng Laundry saya ga khawatir kehabisan baju.',
            'name' => 'Ega Nawwarasa H.',
            'status' => 'Pelanggan Baru',
            'image' => '/assets/testimonial-images/ega.jpeg',
        ],
        [
            'quote' =>
                'Pelayanan nya sangat mantab, karna untuk waktu yg saya tentukan bisa memenuhinya... Cepat dan wangi sekali, terimakasih atas pelayanannya kemaren Ajeng Laundry.',
            'name' => 'Rizky Andika S',
            'status' => 'Pelanggan Baru',
            'image' => '/assets/testimonial-images/rizky.jpeg',
        ],
        [
            'quote' =>
                'Ajeng Laundry tempat laundry andalan, punya layanan terbaik karena bisa express, harganya terjangkau. Recommended untuk pekerja!',
            'name' => 'Juldan Willy F. A.',
            'status' => 'Pelanggan Setia',
            'image' => '/assets/testimonial-images/juldan.jpeg',
        ],
    ];
@endphp

<section class="w-full px-6 md:px-8 py-16 md:py-24 bg-[#F8F9FA] font-poppins">

    <div class="max-w-7xl mx-auto w-full flex flex-col items-center">

        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-ajeng-black text-center mb-16">
            Apa kata pelanggan setia Kami ?
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 md:gap-8 w-full auto-rows-fr">

            @foreach ($testimonials as $testi)
                <x-testi-card quote="{{ $testi['quote'] }}" name="{{ $testi['name'] }}" status="{{ $testi['status'] }}"
                    image="{{ $testi['image'] }}" />
            @endforeach

        </div>

    </div>
</section>
