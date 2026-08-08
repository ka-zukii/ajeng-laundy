<x-layout>
    @props([
    // Data pelanggan (object/array asosiatif), fallback dummy jika tidak dikirim
    'user' => (object) [
        'name' => 'Anang Setiaji',
        'email' => 'anang.setiaji@gmail.com',
        'whatsapp' => '+62851xxxxxxxxx',
        'address' => 'Klangonan, Ngasem, Kec. Colomadu, Kabupaten Karanganyar, Jawa Tengah',
    ],

    // Data transaksi (array of object/array), fallback dummy jika tidak dikirim
    'transactions' => [
        [
            'invoice_id' => 'AJL-20260627-B7N2Q8',
            'date' => '25 - Jun - 2026',
            'payment' => 'Menunggu',
            'laundry' => 'Pending',
            'detail_url' => '#',
        ],
        [
            'invoice_id' => 'AJL-20260627-R4X1M9',
            'date' => '17 - Jun - 2026',
            'payment' => 'Sukses',
            'laundry' => 'Diproses',
            'detail_url' => '#',
        ],
        [
            'invoice_id' => 'AJL-20260627-K8P5T2',
            'date' => '12 - Mar - 2026',
            'payment' => 'Sukses',
            'laundry' => 'Selesai',
            'detail_url' => '#',
        ],
        [
            'invoice_id' => 'AJL-20260627-W3J7F6',
            'date' => '7 - Mar - 2026',
            'payment' => 'Sukses',
            'laundry' => 'Selesai',
            'detail_url' => '#',
        ],
    ],

    // Pagination sederhana (opsional, bisa diganti dengan $transactions->links() jika pakai paginator asli)
    'currentPage' => 1,
    'lastPage' => 2,
])

    <div class="w-full bg-pink-50 px-4 py-10 sm:px-8 md:px-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl mx-auto items-start">

            {{-- ================= KOLOM KIRI (~1/3) ================= --}}
            <div class="lg:col-span-1 flex flex-col gap-6">

                {{-- Card Sapaan --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-pink-400 px-5 py-4">
                        <h2 class="text-white font-bold">
                            Halo! {{ $user->name ?? 'Pelanggan' }}
                        </h2>
                    </div>
                    <div class="min-h-45 p-5">
                        {{-- Ruang konten kosong / bisa diisi banner, promo, dsb --}}
                    </div>
                </div>

                {{-- Card Informasi Pelanggan --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="font-bold text-gray-800 mb-5">Informasi Pelanggan</h2>

                    <div class="space-y-4 text-sm">
                        <div class="flex gap-2 border-b border-gray-200 pb-2">
                            <span class="text-gray-500 w-20 shrink-0">Nama:</span>
                            <span class="text-gray-800 font-medium">{{ $user->name ?? '-' }}</span>
                        </div>
                        <div class="flex gap-2 border-b border-gray-200 pb-2">
                            <span class="text-gray-500 w-20 shrink-0">Email:</span>
                            <span class="text-gray-800 font-medium break-all">{{ $user->email ?? '-' }}</span>
                        </div>
                        <div class="flex gap-2 border-b border-gray-200 pb-2">
                            <span class="text-gray-500 w-20 shrink-0">WhatsApp:</span>
                            <span class="text-gray-800 font-medium">{{ $user->whatsapp ?? '-' }}</span>
                        </div>
                        <div class="flex gap-2 border-b border-gray-200 pb-2">
                            <span class="text-gray-500 w-20 shrink-0">Alamat:</span>
                            <span class="text-gray-800 font-medium">{{ $user->address ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= KOLOM KANAN (~2/3) ================= --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm p-6">

                    {{-- Header: Judul + Search --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                        <h2 class="font-bold text-gray-800 text-lg">Riwayat Transaksi</h2>

                        <form class="w-full sm:w-72" onsubmit="return false;">
                            <div class="flex items-center gap-2 bg-white border border-pink-200 rounded-full px-4 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-pink-400 shrink-0"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <input type="text" name="invoice_search" placeholder="Invoice ID pesanan kamu"
                                    class="w-full text-sm text-gray-600 placeholder-gray-300 outline-none bg-transparent">
                            </div>
                        </form>
                    </div>

                    {{-- Tabel Transaksi --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <tr class="bg-pink-400 text-white">
                                    <th class="px-4 py-3 rounded-l-lg font-semibold">Invoice</th>
                                    <th class="px-4 py-3 font-semibold">Tanggal</th>
                                    <th class="px-4 py-3 font-semibold">Pembayaran</th>
                                    <th class="px-4 py-3 font-semibold">Laundry</th>
                                    <th class="px-4 py-3 rounded-r-lg font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $trx)
                                    @php
                                        // Mendukung baik array asosiatif maupun object
                                        $trx = is_array($trx) ? (object) $trx : $trx;
                                    @endphp
                                    <tr class="border-b border-gray-100 last:border-b-0">
                                        <td class="px-4 py-3 text-pink-500 font-semibold whitespace-nowrap">
                                            {{ $trx->invoice_id }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                                            {{ $trx->date }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                                            {{ $trx->payment }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                                            {{ $trx->laundry }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <a href="{{ $trx->detail_url ?? '#' }}"
                                                class="text-pink-500 font-semibold hover:underline">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                                            Belum ada riwayat transaksi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($lastPage > 1)
                        <div class="flex justify-center items-center gap-2 mt-6">
                            {{-- Tombol Prev --}}
                            <a href="{{ $currentPage > 1 ? '?page=' . ($currentPage - 1) : '#' }}"
                                class="w-8 h-8 flex items-center justify-center rounded-full border border-pink-300 text-pink-400 hover:bg-pink-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.79 5.23a.75.75 0 010 1.06L9.06 10l3.73 3.71a.75.75 0 11-1.06 1.06l-4.25-4.25a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>

                            {{-- Nomor Halaman --}}
                            @for ($page = 1; $page <= $lastPage; $page++)
                                <a href="?page={{ $page }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-medium transition-colors
                                      {{ $page === $currentPage ? 'bg-pink-400 text-white' : 'border border-pink-300 text-pink-400 hover:bg-pink-50' }}">
                                    {{ $page }}
                                </a>
                            @endfor

                            {{-- Tombol Next --}}
                            <a href="{{ $currentPage < $lastPage ? '?page=' . ($currentPage + 1) : '#' }}"
                                class="w-8 h-8 flex items-center justify-center rounded-full border border-pink-300 text-pink-400 hover:bg-pink-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.21 14.77a.75.75 0 010-1.06L10.94 10 7.21 6.29a.75.75 0 111.06-1.06l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-layout>
