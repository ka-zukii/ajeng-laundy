@php
    $layoutName = auth()->check() ? 'pelanggan-layout' : 'landing-page-layout';
@endphp

<x-dynamic-component :component="$layoutName">
    <x-slot:title>
        Detail Invoice {{ $transaksi->kode_transaksi }} - Ajeng Laundry
    </x-slot>

    @php
        $detail = $transaksi->transaksiDetail;
        $statusBayarEnum = $transaksi->pembayaran
            ? $transaksi->pembayaran->status_pembayaran
            : \App\Enums\StatusPembayaran::MENGUNGGU;

        $isSudahBayar = $statusBayarEnum === \App\Enums\StatusPembayaran::SUKSES;
    @endphp

    <div class="w-full px-4 py-10 sm:px-8 md:px-16 font-poppins min-h-screen">
        <div class="max-w-5xl mx-auto">

            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-2xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <div class="text-center mb-10">
                <h1 class="text-2xl md:text-3xl font-bold text-ajeng-pink tracking-wide">
                    Invoice : {{ $transaksi->kode_transaksi }}
                </h1>
                <p class="text-ajeng-gray-1 font-medium mt-2">
                    Tanggal pesan: {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-start">

                <!-- RINCIAN CUCIAN -->
                <div class="lg:col-span-5 bg-ajeng-white rounded-3xl p-6 md:p-8 shadow-sm border border-ajeng-gray-5">
                    <h2 class="text-lg font-bold text-ajeng-black mb-6">Rincian Cucian</h2>

                    <div class="flex flex-col sm:flex-row gap-6">

                        <div
                            class="shrink-0 w-24 h-24 bg-ajeng-bg-pink-1 rounded-2xl flex items-center justify-center border border-ajeng-pink/20">
                            <x-heroicon-o-shopping-bag class="w-12 h-12 text-ajeng-pink" />
                        </div>

                        @php
                            $detail = $transaksi->transaksiDetail;
                        @endphp

                        <div class="flex-1 space-y-3">
                            <h3 class="text-ajeng-pink font-bold text-[15px]">
                                {{ $detail->layanan->nama ?? 'Regular ( Daily Kiloan )' }}
                                {{ $detail->berat ?? 0 }}kg
                            </h3>

                            <div class="grid grid-cols-2 gap-1 text-[13px]">
                                <span class="text-ajeng-gray-2 font-medium">Tanggal Reservasi</span>
                                <span class="text-ajeng-black font-semibold text-right">
                                    {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d F Y') }}
                                </span>

                                <span class="text-ajeng-gray-2 font-medium">Estimasi Selesai</span>
                                <span class="text-ajeng-black font-semibold text-right">
                                    {{ $transaksi->estimasi_selesai ? \Carbon\Carbon::parse($transaksi->estimasi_selesai)->format('d F Y') : '-' }}
                                </span>

                                <span class="text-ajeng-gray-2 font-medium">Transaksi Selesai</span>
                                <span class="text-ajeng-black font-semibold text-right">
                                    {{ $transaksi->tanggal_selesai ? \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d F Y') : '-' }}
                                </span>

                                <span class="text-ajeng-gray-2 font-medium">Biaya Layanan</span>
                                <span class="text-ajeng-pink font-bold text-right">
                                    Rp {{ number_format($transaksi->total_biaya ?? 0, 0, ',', '.') }} /
                                    {{ $detail->berat ?? 0 }}kg
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RINCIAN PESANAN -->
                <div class="lg:col-span-7 flex flex-col gap-6">

                    <div class="bg-ajeng-bg-pink-2 rounded-3xl p-6 md:p-8 shadow-sm">
                        <h2 class="text-lg font-bold text-ajeng-black mb-6">Rincian Pesanan</h2>

                        <div class="space-y-4 text-[14px]">
                            <div class="flex justify-between items-center border-b border-ajeng-gray-4/50 pb-3">
                                <span class="text-ajeng-gray-1 font-medium">Invoice ID</span>
                                <span class="text-ajeng-black font-bold">{{ $transaksi->kode_transaksi }}</span>
                            </div>

                            <div class="flex justify-between items-center border-b border-ajeng-gray-4/50 pb-4">
                                <span class="text-ajeng-gray-1 font-medium">Username Pelanggan</span>
                                <span
                                    class="text-ajeng-black font-semibold">{{ $transaksi->pelanggan->nama ?? 'Pelanggan' }}</span>
                            </div>

                            <div class="flex justify-between items-center pt-2 pb-4 border-b border-ajeng-gray-4/50">
                                <span class="text-ajeng-gray-1 font-medium">Status Pesanan</span>
                                <x-status-badge :color="$transaksi->status_laundry->color()" :label="$transaksi->status_laundry->label()" />
                            </div>

                            <div class="flex justify-between items-center border-b border-ajeng-gray-4/50 py-4">
                                <span class="text-ajeng-gray-1 font-medium">Status Pembayaran</span>

                                @php
                                    $statusBayarEnum = $transaksi->pembayaran
                                        ? $transaksi->pembayaran->status_pembayaran
                                        : \App\Enums\StatusPembayaran::MENGUNGGU;
                                @endphp

                                <x-status-badge :color="$statusBayarEnum->color()" :label="$statusBayarEnum->label()" />
                            </div>

                            <div class="flex justify-between items-center pt-2 pb-4">
                                <span class="text-ajeng-gray-1 font-medium">Jenis Layanan</span>
                                <span
                                    class="text-ajeng-black font-bold">{{ $detail->layanan->nama ?? 'Regular ( Daily Kiloan )' }}</span>
                            </div>

                            <div class="pt-4 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-ajeng-gray-2 font-medium">Total Item</span>
                                    <span class="text-ajeng-black font-bold">{{ $detail->berat ?? 0 }}kg</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-ajeng-gray-2 font-medium">Total Harga</span>
                                    <span class="text-ajeng-black font-bold">Rp
                                        {{ number_format($transaksi->total_biaya ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-ajeng-gray-2 font-medium">Biaya Admin</span>
                                    <span class="text-ajeng-black font-bold">Rp 500</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-ajeng-gray-2 font-medium">Biaya Layanan</span>
                                    <span class="text-ajeng-black font-bold">Rp 1.000</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center border-t border-ajeng-gray-4/80 mt-4 pt-5">
                                <span class="text-ajeng-pink font-bold text-[15px]">Total Akhir</span>
                                <span class="text-ajeng-pink font-bold text-[15px]">
                                    Rp {{ number_format(($transaksi->total_biaya ?? 0) + 1500, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if (!$isSudahBayar)
                        <button type="button" onclick="openModal()"
                            class="w-full bg-ajeng-white rounded-2xl p-5 shadow-sm border-2 border-ajeng-pink hover:bg-ajeng-bg-pink-1 transition-all flex justify-between items-center cursor-pointer group">
                            <span class="text-ajeng-black font-bold text-[15px]">Metode Pembayaran</span>
                            <span class="text-ajeng-pink font-bold text-[15px] flex items-center gap-2">
                                Pilih Pembayaran
                                <x-heroicon-m-chevron-right
                                    class="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                            </span>
                        </button>
                    @else
                        <div
                            class="w-full bg-ajeng-gray-5 rounded-2xl p-5 shadow-sm border border-ajeng-gray-4 flex justify-between items-center opacity-75 cursor-not-allowed">
                            <span class="text-ajeng-gray-2 font-bold text-[15px]">Metode Pembayaran</span>
                            <span class="text-green-600 font-bold text-[15px] flex items-center gap-1.5">
                                <x-heroicon-s-check-circle class="w-5 h-5" />
                                Lunas ({{ strtoupper($transaksi->pembayaran->payment_type ?? 'QRIS') }})
                            </span>
                        </div>
                    @endif

                    {{-- TOMBOL AKSI --}}
                    <div class="flex flex-col gap-3 mt-2">
                        <a href="{{ route('pelanggan.invoice.download', $transaksi->kode_transaksi) }}"
                            class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold text-center py-4 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                            <x-heroicon-o-arrow-down-tray class="w-5 h-5" />
                            Download Invoice PDF
                        </a>
                        <a href="{{ url('/') }}"
                            class="w-full bg-ajeng-pink hover:bg-[#e36685] text-white font-bold text-center py-4 rounded-xl transition-colors shadow-sm">
                            Kembali ke Beranda
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @if($transaksi->pembayaran)
        <x-payment-modal :transaksi="$transaksi" />
    @endif
</x-dynamic-component>
