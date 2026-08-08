<x-layout>
    @props([
        // Header
        'invoiceId' => 'AJL-20260627-R4X1M9',
        'orderDate' => '17 Januari 2026',
    
        // Kartu Kiri - Rincian Cucian
        'serviceName' => 'Regular ( Daily Kiloan )',
        'serviceWeight' => '5kg',
        'reservationDate' => '17 Januari 2026',
        'estimatedDate' => '19 Januari 2026',
        'transactionDate' => '-',
        'serviceFeeLabel' => '40.000 / 5kg',
    
        // Kartu Kanan - Rincian Pesanan
        'customerName' => 'Anang Setiaji',
        'orderStatus' => 'Sukses',
        'paymentStatus' => 'Sukses',
        'totalItem' => '5kg',
        'totalPrice' => 'Rp 40.000',
        'adminFee' => 'Rp 500',
        'serviceFee' => 'Rp 1.000',
        'totalFinal' => 'Rp 41.000',
    
        // Metode Pembayaran & Aksi
        'paymentMethod' => 'QRIS',
        'downloadUrl' => '#',
        'checkProcessUrl' => '#',
    ])

    <div class="w-full bg-pink-50 px-4 py-10 sm:px-8 md:px-16">

        {{-- Header Invoice --}}
        <div class="text-center mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-pink-500">
                Invoice : {{ $invoiceId }}
            </h1>
            <p class="text-gray-400 mt-1">
                Tanggal pesan: {{ $orderDate }}
            </p>
        </div>

        {{-- Layout 2 Kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start max-w-4xl mx-auto">

            {{-- ================= KARTU KIRI: RINCIAN CUCIAN ================= --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="font-bold text-gray-800 mb-4">Rincian Cucian</h2>

                <div class="flex gap-4">
                    {{-- Ilustrasi / Icon Laundry --}}
                    <div class="shrink-0 w-16 h-16 rounded-xl bg-sky-50 flex items-center justify-center text-3xl">
                        <span role="img" aria-label="laundry basket">🧺</span>
                    </div>

                    {{-- Detail Layanan --}}
                    <div class="flex-1">
                        <p class="text-pink-500 font-semibold text-sm mb-2">
                            {{ $serviceName }} {{ $serviceWeight }}
                        </p>

                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-400">Tanggal Reservasi</span>
                                <span class="text-gray-800 font-medium">{{ $reservationDate }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-400">Estimasi Selesai</span>
                                <span class="text-gray-800 font-medium">{{ $estimatedDate }}</span>
                            </div>
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-400">Transaksi Selesai</span>
                                <span class="text-gray-800 font-medium">{{ $transactionDate }}</span>
                            </div>
                        </div>

                        <p class="text-pink-500 font-semibold text-sm mt-3">
                            {{ $serviceFeeLabel }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- ================= KOLOM KANAN ================= --}}
            <div class="flex flex-col gap-6">

                {{-- Kartu Rincian Pesanan --}}
                <div class="bg-pink-100/60 rounded-2xl p-6">
                    <h2 class="font-bold text-gray-800 mb-4">Rincian Pesanan</h2>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Invoice ID</span>
                            <span class="text-gray-900 font-semibold">{{ $invoiceId }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Username Pelanggan</span>
                            <span class="text-gray-900 font-semibold">{{ $customerName }}</span>
                        </div>
                    </div>

                    <hr class="border-pink-200 my-4">

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status Pesanan</span>
                            <span
                                class="inline-flex items-center gap-1 bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.704 5.29a1 1 0 010 1.42l-7.5 7.5a1 1 0 01-1.42 0l-3.5-3.5a1 1 0 111.42-1.42L8.5 12.08l6.79-6.79a1 1 0 011.42 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $orderStatus }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status Pembayaran</span>
                            <span
                                class="inline-flex items-center gap-1 bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.704 5.29a1 1 0 010 1.42l-7.5 7.5a1 1 0 01-1.42 0l-3.5-3.5a1 1 0 111.42-1.42L8.5 12.08l6.79-6.79a1 1 0 011.42 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $paymentStatus }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jenis Layanan</span>
                            <span class="text-gray-900 font-semibold">{{ $serviceName }}</span>
                        </div>
                    </div>

                    <hr class="border-pink-200 my-4">

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Item</span>
                            <span class="text-gray-900 font-semibold">{{ $totalItem }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Total Harga</span>
                            <span class="text-gray-900 font-semibold">{{ $totalPrice }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Biaya Admin</span>
                            <span class="text-gray-900 font-semibold">{{ $adminFee }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Biaya Layanan</span>
                            <span class="text-gray-900 font-semibold">{{ $serviceFee }}</span>
                        </div>
                    </div>

                    <hr class="border-pink-200 my-4">

                    <div class="flex justify-between items-center">
                        <span class="text-pink-500 font-semibold">Total Akhir</span>
                        <span class="text-pink-500 font-bold text-lg">{{ $totalFinal }}</span>
                    </div>
                </div>

                {{-- Card Metode Pembayaran --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 flex justify-between items-center">
                    <span class="text-gray-800 font-medium">Metode Pembayaran</span>
                    <span class="text-gray-800 font-semibold">{{ $paymentMethod }}</span>
                </div>

                {{-- Tombol Aksi --}}
                <a href="{{ $downloadUrl }}"
                    class="w-full text-center bg-sky-300 hover:bg-sky-400 transition-colors text-white font-semibold py-3 rounded-full">
                    Download Invoice
                </a>

                <a href="{{ $checkProcessUrl }}"
                    class="w-full text-center bg-pink-300 hover:bg-pink-400 transition-colors text-white font-semibold py-3 rounded-full">
                    Cek Proses
                </a>

            </div>
        </div>
    </div>

</x-layout>
