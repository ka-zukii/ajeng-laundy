<x-pelanggan-layout>
    <x-slot:title>
        Dasbor Pelanggan - Ajeng Laundry
    </x-slot>

    <div class="w-full px-4 py-10 sm:px-8 md:px-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl mx-auto items-start">

            <div class="lg:col-span-1 flex flex-col gap-6">

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="bg-pink-400 px-5 py-4">
                        <h2 class="text-white font-bold text-lg tracking-wide">
                            Halo, {{ $pelanggan->nama ?? $user->username }}!
                        </h2>
                    </div>
                    <div
                        class="min-h-32 p-5 flex flex-col justify-center items-center text-center bg-linear-to-br from-white to-pink-50">
                        <span class="text-pink-500 font-semibold mb-1">Status Member Aktif</span>
                        <p class="text-xs text-gray-400">Terima kasih telah mempercayakan cucian Anda kepada kami.</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h2 class="font-bold text-gray-800 mb-5">Informasi Profil</h2>

                    <div class="space-y-4 text-sm">
                        <div class="flex gap-2 border-b border-gray-100 pb-3">
                            <span class="text-gray-400 w-24 shrink-0">Nama:</span>
                            <span class="text-gray-800 font-semibold">{{ $pelanggan->nama ?? '-' }}</span>
                        </div>
                        <div class="flex gap-2 border-b border-gray-100 pb-3">
                            <span class="text-gray-400 w-24 shrink-0">Email:</span>
                            <span class="text-gray-800 font-semibold break-all">{{ $user->email }}</span>
                        </div>
                        <div class="flex gap-2 border-b border-gray-100 pb-3">
                            <span class="text-gray-400 w-24 shrink-0">WhatsApp:</span>
                            <span class="text-gray-800 font-semibold">{{ $pelanggan->nomor_telepon ?? '-' }}</span>
                        </div>
                        <div class="flex gap-2 pt-1">
                            <span class="text-gray-400 w-24 shrink-0">Alamat:</span>
                            <span class="text-gray-800 font-semibold">{{ $pelanggan->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">
                        <h2 class="font-bold text-gray-800 text-lg">Riwayat Transaksi</h2>

                        <form class="w-full sm:w-72" onsubmit="return false;">
                            <div
                                class="flex items-center gap-2 bg-gray-50 border border-gray-200 focus-within:border-pink-300 focus-within:ring-2 focus-within:ring-pink-100 rounded-xl px-4 py-2 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <input type="text" name="invoice_search" placeholder="Cari nomor invoice..."
                                    class="w-full text-sm text-gray-600 placeholder-gray-400 outline-none bg-transparent border-none focus:ring-0 p-0">
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100 mb-4">
                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 border-b border-gray-100">
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap">Kode Transaksi</th>
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap">Tanggal Masuk</th>
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap">Total Biaya</th>
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap">Status</th>
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $trx)
                                    <tr
                                        class="border-b border-gray-100 hover:bg-pink-50/30 transition-colors last:border-b-0">
                                        <td class="px-4 py-3 text-pink-500 font-semibold whitespace-nowrap">
                                            {{ $trx->kode_transaksi }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($trx->tanggal_masuk)->format('d M Y - H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700 whitespace-nowrap font-medium">
                                            {{ $trx->total_biaya ? 'Rp ' . number_format($trx->total_biaya, 0, ',', '.') : 'Belum Dihitung' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{-- Memberikan warna berbeda berdasarkan status (opsional) --}}
                                            <span
                                                class="px-2.5 py-1 rounded-md text-xs font-semibold
                                                {{ $trx->status_laundry === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $trx->status_laundry === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ ucfirst($trx->status_laundry) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <a href="#"
                                                class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-pink-500 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                                    </path>
                                                </svg>
                                                <span>Belum ada riwayat transaksi cucian.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (count($transactions) > 0)
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-pelanggan-layout>
