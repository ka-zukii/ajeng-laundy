<x-layout>
    <!-- Wrapper utama halaman, diberi background pink-50 (#fdf2f8) -->
    <div class="min-h-screen bg-[#fdf2f8] p-4 sm:p-8 flex items-center justify-center"
        style="font-family: 'Poppins', sans-serif;">

        <!-- Container Utama -->
        <div class="bg-white w-full max-w-6xl rounded-4xl shadow-sm border border-pink-50 p-8 md:p-10">

            <!-- Judul -->
            <h2 class="text-3xl font-semibold text-[#f472b6] mb-8 tracking-wide">Daftar Reservasi</h2>

            <!-- Wrapper Tabel untuk Responsivitas -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0 min-w-200">
                    <thead>
                        <tr class="bg-[#f472b6] text-white">
                            <th class="py-4 px-6 font-medium rounded-l-full">ID Reservasi</th>
                            <th class="py-4 px-4 font-medium">Waktu Penjemputan</th>
                            <th class="py-4 px-4 font-medium">Nama Pelanggan</th>
                            <th class="py-4 px-4 font-medium">No. WhatsApp</th>
                            <th class="py-4 px-4 font-medium">Status</th>
                            <th class="py-4 px-6 font-medium rounded-r-full">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">

                        {{-- Looping Data dari Database --}}
                        @forelse ($reservasis as $reservasi)
                            <tr>
                                <td class="py-4 px-6 text-[#f472b6] font-medium border-b border-pink-100">
                                    #RES-{{ str_pad($reservasi->id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-4 px-4 text-gray-700 border-b border-pink-100">
                                    {{ \Carbon\Carbon::parse($reservasi->tanggal_penjemputan)->translatedFormat('d M Y - H:i') }}
                                </td>
                                <td class="py-4 px-4 text-gray-700 border-b border-pink-100">
                                    {{ $reservasi->pelanggan->nama ?? '-' }}
                                </td>
                                <td class="py-4 px-4 text-gray-700 border-b border-pink-100">
                                    {{ $reservasi->pelanggan->nomor_telepon ?? '-' }}
                                </td>
                                <td class="py-4 px-4 border-b border-pink-100">
                                    @php
                                        // Mapping warna berdasarkan value Enum StatusReservation
                                        $statusVal = $reservasi->status_reservation->value ?? '';
                                        $badgeClass = match ($statusVal) {
                                            'menunggu' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'dijadwalkan' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                            'dibatalkan' => 'bg-red-100 text-red-700 border-red-200',
                                            default => 'bg-gray-100 text-gray-700 border-gray-200',
                                        };
                                    @endphp

                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded-full border {{ $badgeClass }}">
                                        {{ $reservasi->status_reservation->label() }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 border-b border-pink-100">
                                    {{-- Sesuaikan rute ini dengan rute detail reservasimu nantinya --}}
                                    <a href="{{ route('reservation.success', $reservasi->id) }}"
                                        class="text-[#f472b6] font-medium hover:text-pink-600 hover:underline transition">Detail</a>
                                </td>
                            </tr>
                        @empty
                            {{-- Tampilan jika data kosong --}}
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500 font-medium">
                                    Belum ada reservasi saat ini.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            @if ($reservasis->hasPages())
                <div class="flex items-center justify-center gap-3 mt-10">

                    {{-- Tombol Previous --}}
                    @if ($reservasis->onFirstPage())
                        <button disabled
                            class="w-10 h-10 rounded-full border border-pink-200 bg-pink-50 text-pink-300 flex items-center justify-center cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                    @else
                        <a href="{{ $reservasis->previousPageUrl() }}"
                            class="w-10 h-10 rounded-full border border-[#f472b6] bg-pink-100 text-[#f472b6] flex items-center justify-center hover:bg-[#f472b6] hover:text-white transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                    @endif

                    {{-- Deretan Angka Halaman --}}
                    @foreach ($reservasis->getUrlRange(1, $reservasis->lastPage()) as $page => $url)
                        @if ($page == $reservasis->currentPage())
                            <!-- Halaman Aktif -->
                            <button
                                class="w-10 h-10 rounded-full bg-[#f8a5c2] text-white border border-[#f8a5c2] flex items-center justify-center font-medium shadow-sm cursor-default">
                                {{ $page }}
                            </button>
                        @else
                            <!-- Halaman Tidak Aktif -->
                            <a href="{{ $url }}"
                                class="w-10 h-10 rounded-full border border-[#f472b6] text-[#f472b6] flex items-center justify-center font-medium hover:bg-pink-50 transition duration-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($reservasis->hasMorePages())
                        <a href="{{ $reservasis->nextPageUrl() }}"
                            class="w-10 h-10 rounded-full border border-[#f472b6] bg-pink-100 text-[#f472b6] flex items-center justify-center hover:bg-[#f472b6] hover:text-white transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    @else
                        <button disabled
                            class="w-10 h-10 rounded-full border border-pink-200 bg-pink-50 text-pink-300 flex items-center justify-center cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    @endif

                </div>
            @endif

        </div>
    </div>
</x-layout>
