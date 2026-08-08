<x-layout>
    <div class="flex items-center justify-center min-h-[70vh] py-12 px-4 bg-pink-50/40">
        <!-- Wrapper luar dengan border putus-putus biru muda -->
        <div class="p-3 rounded-4xl border-2 border-dashed border-blue-300 max-w-4xl w-full">

            <div class="bg-white p-8 md:p-12 rounded-3xl shadow-lg shadow-pink-100 w-full">

                <!-- Ikon Sukses -->
                <div class="flex justify-center mb-6">
                    <div class="bg-pink-100 text-pink-500 rounded-full p-4 ring-4 ring-pink-50">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Reservasi Berhasil!</h2>
                    <p class="text-gray-500 mt-2 text-sm">Terima kasih, kurir kami akan menjemput pakaian Anda sesuai
                        jadwal.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <!-- 1. KARTU DETAIL RESERVASI -->
                    <div class="bg-pink-50/50 p-4 rounded-2xl space-y-3 text-sm">
                        <div class="flex justify-between items-center border-b border-pink-100 pb-2">
                            <span class="text-gray-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                ID Reservasi
                            </span>
                            <span class="font-bold text-gray-800">#{{ $reservation->id }}</span>
                        </div>

                        <div class="flex flex-col gap-1 border-b border-pink-100 pb-2">
                            <span class="text-gray-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Waktu Penjemputan
                            </span>
                            <span class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($reservation->tanggal_penjemputan)->translatedFormat('l, d F Y - H:i') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Status
                            </span>
                            <!-- Memanggil label() dari Enum -->
                            <span
                                class="px-3 py-1 bg-pink-100 text-pink-600 rounded-full text-xs font-bold uppercase tracking-wider">
                                {{ $reservation->status_reservation->label() }}
                            </span>
                        </div>
                    </div>

                    <!-- 2. KARTU INFORMASI PELANGGAN -->
                    <div class="bg-gray-50 p-4 rounded-2xl space-y-3 text-sm">
                        <h3 class="font-bold text-gray-700 border-b border-gray-200 pb-2 mb-2">Informasi Pelanggan</h3>

                        <div class="flex justify-between items-center pb-1">
                            <span class="text-gray-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nama
                            </span>
                            <span class="font-medium text-gray-800">{{ $reservation->pelanggan->nama ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between items-center pb-1">
                            <span class="text-gray-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                No. WhatsApp
                            </span>
                            <span
                                class="font-medium text-gray-800">{{ $reservation->pelanggan->nomor_telepon ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between items-start">
                            <span class="text-gray-500 flex items-center gap-1.5 pt-0.5">
                                <svg class="w-4 h-4 text-pink-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat
                            </span>
                            <span
                                class="font-medium text-gray-800 text-right max-w-[60%]">{{ $reservation->pelanggan->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- KARTU KODE TRANSAKSI -->
                @if (
                    $reservation->status_reservation === App\Enums\StatusReservation::MENUNGGU ||
                        $reservation->status_reservation === App\Enums\StatusReservation::DIJADWALKAN)
                    <div class="bg-blue-50 p-4 rounded-2xl border-2 border-dashed border-blue-200 mb-6">
                        <p class="text-sm text-blue-500 text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Kode Transaksi untuk melacak laundry akan muncul di sini setelah petugas kami menerima
                            pakaian Anda.
                        </p>
                    </div>
                @elseif($reservation->transaksi)
                    <div class="bg-pink-50 p-4 rounded-2xl border-2 border-dashed border-pink-200 mb-6">
                        <p class="text-xs text-pink-500 mb-2 font-medium">Pakaian Anda telah diterima! Gunakan kode
                            berikut untuk melacak detail laundry:</p>
                        <div class="flex justify-between items-center bg-white p-2.5 rounded-xl">
                            <span class="text-gray-600 text-sm">Kode Transaksi</span>
                            <span
                                class="font-extrabold text-pink-500 text-lg tracking-widest">{{ $reservation->transaksi->kode_transaksi }}</span>
                        </div>
                    </div>
                @endif

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="window.print()"
                        class="w-full bg-pink-400 text-white font-semibold py-3 rounded-full hover:bg-pink-500 transition-all duration-200 hover:-translate-y-1 hover:shadow-md hover:shadow-pink-200 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        Cetak Bukti Reservasi
                    </button>

                    <a href="{{ url('/') }}"
                        class="w-full block text-center bg-pink-50 text-pink-500 font-semibold py-3 rounded-full hover:bg-pink-100 transition-all duration-200 hover:-translate-y-1">
                        Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-layout>
