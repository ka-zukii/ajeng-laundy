<section id="layanan"
    class="w-full px-6 md:px-8 py-16 md:py-24 flex flex-col gap-4 md:gap-6 items-center justify-center">

    <h2 class="text-ajeng-black font-bold text-3xl md:text-4xl lg:text-5xl text-center tracking-tight">
        Layanan Ajeng Laundry
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 w-full max-w-7xl mx-auto">

        @foreach ($layanans as $layanan)
            <x-services-card title="{{ $layanan->nama_layanan }}" price="{{ $layanan->biaya_layanan }}"
                unit="{{ $layanan->jenis_perhitungan->value }}" />
        @endforeach

    </div>

</section>
