<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pembayaran - Ajeng Laundry</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-linear-to-b from-ajeng-bg-pink-2 to-ajeng-white font-poppins">

    <div class="w-full px-4 py-12 md:py-20 flex justify-center items-center min-h-screen">

        @if (session('error'))
            <div class="w-full max-w-md bg-red-50 border border-red-200 text-red-600 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm animate-bounce"
                style="animation-iteration-count: 1;">
                <x-heroicon-s-exclamation-circle class="w-6 h-6 shrink-0 text-red-500" />
                <div class="text-[14px] font-medium leading-relaxed">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="relative bg-ajeng-white rounded-3xl shadow-sm border border-ajeng-gray-5 w-full max-w-md p-6 md:p-8 animate-float"
            style="animation-duration: 8s;">

            @php
                $kembaliUrl = route('detail-transaksi', $transaksi->id ?? $pembayaran->transaksi->id);
                if (
                    auth()->check() &&
                    in_array(auth()->user()->role, [\App\Enums\UserRole::OWNER, \App\Enums\UserRole::KARYAWAN])
                ) {
                    $kembaliUrl = \App\Filament\Resources\Pembayarans\PembayaranResource::getUrl('view', [
                        'record' => $pembayaran->id,
                    ]);
                }
            @endphp

            <a href="{{ $kembaliUrl }}"
                class="absolute top-6 left-6 sm:top-8 sm:left-8 flex items-center gap-1.5 text-ajeng-gray-2 hover:text-ajeng-pink transition-colors text-sm font-medium">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Kembali
            </a>

            <div class="flex flex-col items-center text-center mb-8 mt-6">
                <div
                    class="w-16 h-16 bg-ajeng-bg-pink-1 text-ajeng-pink rounded-full flex items-center justify-center mb-5 border border-ajeng-pink/20">
                    <x-heroicon-o-banknotes class="w-8 h-8" />
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-ajeng-black tracking-tight mb-2">Tagihan Laundry</h2>
                <p class="text-sm text-ajeng-gray-1 leading-relaxed">Pesanan Anda siap diproses.</p>
            </div>

            <div class="space-y-4 mb-8 bg-ajeng-gray-5/50 p-5 rounded-2xl border border-ajeng-gray-4/50">
                <div class="flex justify-between items-center border-b border-ajeng-gray-4/70 pb-3">
                    <span class="text-[14px] font-medium text-ajeng-gray-1">Kode Transaksi</span>
                    <span class="text-[14px] font-bold text-ajeng-black">{{ $transaksi->kode_transaksi }}</span>
                </div>
                <div class="flex justify-between items-center pt-1">
                    <span class="text-[14px] font-medium text-ajeng-gray-1">Total Pembayaran</span>
                    <span class="text-lg font-bold text-ajeng-pink">
                        Rp {{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <button type="button" onclick="openModal()"
                class="w-full py-4 px-4 bg-ajeng-pink hover:bg-[#e36685] text-ajeng-white font-bold rounded-xl shadow-md shadow-ajeng-pink/20 transition-all flex justify-center items-center gap-2 cursor-pointer">
                Pilih Metode Pembayaran
            </button>
        </div>
    </div>

    <x-payment-modal :transaksi="$transaksi" />

</body>

</html>
