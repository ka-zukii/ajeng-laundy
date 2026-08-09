<x-pelanggan-layout>
    <x-slot:title>
        Detail Invoice {{ $transaksi->kode_transaksi }} - Ajeng Laundry
    </x-slot>

    <div class="w-full px-4 py-10 sm:px-8 md:px-16 font-poppins min-h-screen">
        <div class="max-w-5xl mx-auto">

            <div class="text-center mb-10">
                <h1 class="text-2xl md:text-3xl font-bold text-ajeng-pink tracking-wide">
                    Invoice : {{ $transaksi->kode_transaksi }}
                </h1>
                <p class="text-ajeng-gray-1 font-medium mt-2">
                    Tanggal pesan: {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->translatedFormat('d F Y') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-start">

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

                    <div
                        class="bg-ajeng-white rounded-2xl p-5 shadow-sm border border-ajeng-gray-5 flex justify-between items-center mt-2">
                        <span class="text-ajeng-black font-bold text-[15px]">Metode Pembayaran</span>
                        <span class="text-ajeng-black font-bold text-[15px]">QRIS</span>
                    </div>

                    <div class="flex flex-col gap-3 mt-2">
                        <a href="{{ route('pelanggan.invoice.download', $transaksi->kode_transaksi) }}"
                            class="w-full bg-blue-500 hover:bg-blue-400 text-ajeng-white font-bold text-center py-4 rounded-xl transition-colors shadow-sm">
                            Download Invoice
                        </a>
                        <a href="#"
                            class="w-full bg-ajeng-pink hover:bg-ajeng-pink/50 text-ajeng-white font-bold text-center py-4 rounded-xl transition-colors shadow-sm">
                            Cek Proses
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-pelanggan-layout>
