<x-pelanggan-layout>
    <x-slot:title>
        Dasbor Pelanggan - Ajeng Laundry
    </x-slot>

    <div class="w-full px-4 py-8 sm:py-12 md:px-16 font-poppins">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-7xl mx-auto items-start">

            <div class="lg:col-span-1 flex flex-col gap-8">

                <div class="bg-ajeng-white rounded-2xl shadow-sm border border-ajeng-gray-4 overflow-hidden transition-all hover:shadow-md">
                    <div class="bg-ajeng-pink px-6 py-5">
                        <h2 class="text-ajeng-white font-bold text-xl tracking-wide flex items-center gap-2">
                            Halo! {{ $pelanggan->nama ?? $user->username }}
                        </h2>
                    </div>
                    <div class="p-6 flex flex-col items-center text-center bg-linear-to-b from-ajeng-bg-pink-2 to-ajeng-white">
                        <div class="w-16 h-16 bg-ajeng-bg-pink-1 rounded-full flex items-center justify-center mb-4 text-ajeng-pink border border-ajeng-pink/20">
                            <x-heroicon-o-sparkles class="w-8 h-8" />
                        </div>
                        <h3 class="text-lg font-bold text-ajeng-black mb-1">Selamat Datang Kembali!</h3>
                        <p class="text-sm text-ajeng-gray-1 leading-relaxed">
                            Pantau status cucianmu secara <span class="italic">real-time</span> dan nikmati layanan laundry terbaik. Semua riwayat transaksimu tersimpan rapi di sini.
                        </p>
                    </div>
                </div>

                <div class="bg-ajeng-white rounded-2xl shadow-sm border border-ajeng-gray-4 p-6 lg:p-8">
                    <h2 class="font-bold text-ajeng-black text-xl mb-8">Informasi Pelanggan</h2>

                    <div class="space-y-6 text-[15px]">

                        <div class="flex items-end gap-3">
                            <span class="text-ajeng-black font-medium w-24 shrink-0">Nama:</span>
                            <div class="border-b border-ajeng-gray-4 flex-1 pb-1">
                                <span class="text-ajeng-dark-1">{{ $pelanggan->nama ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="flex items-end gap-3">
                            <span class="text-ajeng-black font-medium w-24 shrink-0">Email:</span>
                            <div class="border-b border-ajeng-gray-4 flex-1 pb-1 overflow-hidden">
                                <span class="text-ajeng-dark-1 break-all">{{ $user->email }}</span>
                            </div>
                        </div>

                        <div class="flex items-end gap-3">
                            <span class="text-ajeng-black font-medium w-24 shrink-0">WhatsApp:</span>
                            <div class="border-b border-ajeng-gray-4 flex-1 pb-1">
                                <span class="text-ajeng-dark-1">{{ $pelanggan->nomor_telepon ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="flex items-end gap-3">
                            <span class="text-ajeng-black font-medium w-24 shrink-0">Alamat:</span>
                            <div class="border-b border-ajeng-gray-4 flex-1 pb-1">
                                <span class="text-ajeng-dark-1">{{ $pelanggan->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">

                <div class="bg-ajeng-white rounded-2xl shadow-sm border border-ajeng-gray-4 p-6 lg:p-8">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-8">
                        <h2 class="font-bold text-ajeng-black text-2xl tracking-tight">Riwayat Transaksi</h2>

                        <form class="w-full sm:w-[320px]" onsubmit="return false;">
                            <div class="flex items-center p-1 bg-ajeng-white border border-ajeng-pink/50 rounded-full focus-within:border-ajeng-pink focus-within:ring-4 focus-within:ring-ajeng-bg-pink-1 transition-all">

                                <div class="bg-ajeng-pink text-ajeng-white p-2 rounded-full shrink-0">
                                    <x-heroicon-o-receipt-percent class="w-5 h-5" />
                                </div>

                                <input type="text" name="invoice_search" placeholder="Invoice ID pesanan kamu"
                                    class="w-full text-sm font-medium text-ajeng-black placeholder-ajeng-gray-2 bg-transparent border-none focus:ring-0 px-3 py-1 outline-none">
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto mb-6">
                        <table class="w-full text-sm text-left border-collapse min-w-150">
                            <thead>
                                <tr class="bg-ajeng-pink text-ajeng-white">
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap rounded-tl-xl">Invoice</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Tanggal</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Total Biaya</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap">Laundry</th>
                                    <th class="px-5 py-4 font-semibold whitespace-nowrap text-center rounded-tr-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ajeng-gray-4 border-b border-ajeng-gray-4">
                                @forelse ($transactions as $trx)
                                    <tr class="hover:bg-ajeng-bg-pink-2 transition-colors">

                                        <td class="px-5 py-4 text-ajeng-pink font-semibold whitespace-nowrap">
                                            {{ $trx->kode_transaksi }}
                                        </td>

                                        <td class="px-5 py-4 text-ajeng-dark-1 whitespace-nowrap font-medium">
                                            {{ \Carbon\Carbon::parse($trx->tanggal_masuk)->format('d - M - Y') }}
                                        </td>

                                        <td class="px-5 py-4 text-ajeng-dark-1 whitespace-nowrap">
                                            {{ $trx->total_biaya ? 'Rp ' . number_format($trx->total_biaya, 0, ',', '.') : 'Menunggu' }}
                                        </td>

                                        <td class="px-5 py-4 text-ajeng-dark-1 whitespace-nowrap capitalize">
                                            {{ $trx->status_laundry }}
                                        </td>

                                        <td class="px-5 py-4 whitespace-nowrap text-center">
                                            <a href="#" class="text-ajeng-pink font-medium hover:underline">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center text-ajeng-gray-2">
                                                <x-heroicon-o-inbox class="w-16 h-16 mb-4 text-ajeng-gray-3" />
                                                <span class="font-medium text-ajeng-dark-1 text-base">Belum ada riwayat transaksi cucian.</span>
                                                <p class="text-sm mt-1 text-ajeng-gray-1">Pesanan laundry Anda akan otomatis muncul di sini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if (count($transactions) > 0)
                        <div class="mt-4 flex justify-center">
                            {{ $transactions->links() }}
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-pelanggan-layout>