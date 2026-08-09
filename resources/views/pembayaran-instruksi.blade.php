<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran - Ajeng Laundry</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-linear-to-b from-ajeng-bg-pink-2 to-ajeng-white font-poppins">

    <div class="w-full px-4 py-12 md:py-20 flex justify-center items-center min-h-screen">
        <div class="bg-ajeng-white rounded-3xl shadow-sm border border-ajeng-gray-5 w-full max-w-md p-6 md:p-8 animate-float"
            style="animation-duration: 8s;">

            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-ajeng-black mb-2">Instruksi Pembayaran</h2>
                <p class="text-sm text-ajeng-gray-1">Selesaikan pembayaran Anda sebelum batas waktu berakhir.</p>
            </div>

            <div class="space-y-6">
                <div class="bg-ajeng-gray-5/50 p-5 rounded-2xl border border-ajeng-gray-4/50 text-center">
                    <span class="block text-[14px] font-medium text-ajeng-gray-1 mb-1">Total Pembayaran</span>
                    <span class="text-3xl font-bold text-ajeng-pink">
                        Rp {{ number_format($pembayaran->jumlah_pembayaran, 0, ',', '.') }}
                    </span>
                </div>

                @if (in_array($pembayaran->payment_type, ['bank_transfer', 'echannel']))
                    <div class="bg-ajeng-white border border-ajeng-gray-4 rounded-2xl p-5 text-center shadow-sm">
                        <span class="block text-xs font-bold text-ajeng-gray-2 uppercase tracking-wider mb-2">
                            Bank {{ strtoupper($pembayaran->bank ?? 'Transfer') }}
                        </span>
                        <span class="block text-2xl font-bold text-ajeng-black tracking-widest mb-3">
                            {{ $pembayaran->va_number }}
                        </span>
                        <p class="text-xs text-ajeng-gray-1">Gunakan nomor Virtual Account di atas untuk melakukan
                            transfer.</p>
                    </div>
                @elseif($pembayaran->payment_type === 'qris')
                    <div
                        class="bg-ajeng-white border border-ajeng-gray-4 rounded-2xl p-5 flex flex-col items-center shadow-sm">
                        <span class="block text-xs font-bold text-ajeng-gray-2 uppercase tracking-wider mb-3">
                            Scan QRIS
                        </span>
                        @if ($pembayaran->catatan)
                            <img src="{{ $pembayaran->catatan }}" alt="QR Code QRIS"
                                class="w-48 h-48 object-cover rounded-xl border border-gray-200 p-2 mb-3">
                        @else
                            <div class="w-48 h-48 bg-gray-100 rounded-xl flex items-center justify-center mb-3">QR Tidak
                                Tersedia</div>
                        @endif
                        <p class="text-xs text-ajeng-gray-1 text-center">Buka aplikasi e-Wallet atau Mobile Banking
                            Anda, lalu scan QR Code ini.</p>
                    </div>
                @elseif(in_array($pembayaran->payment_type, ['gopay', 'shopeepay']))
                    <div
                        class="bg-ajeng-white border border-ajeng-gray-4 rounded-2xl p-5 flex flex-col items-center shadow-sm text-center">
                        <span class="block text-xs font-bold text-ajeng-gray-2 uppercase tracking-wider mb-2">
                            {{ strtoupper($pembayaran->payment_type) }}
                        </span>
                        <p class="text-xs text-ajeng-gray-1 mb-4">Klik tombol di bawah ini untuk membuka simulasi
                            pembayaran e-wallet.</p>

                        @if ($pembayaran->catatan)
                            <a href="{{ $pembayaran->catatan }}"
                                class="w-full py-3 px-4 bg-ajeng-pink hover:bg-[#e36685] text-white font-bold rounded-xl transition-all shadow-sm">
                                Buka Simulasi Aplikasi
                            </a>
                        @else
                            <p class="text-xs text-red-500">Tautan pembayaran tidak ditemukan.</p>
                        @endif
                    </div>
                @else
                    <div class="text-center p-5 border border-ajeng-gray-4 rounded-2xl">
                        <p class="font-medium text-ajeng-black">Metode: {{ strtoupper($pembayaran->payment_type) }}</p>
                        <p class="text-sm text-ajeng-gray-1 mt-2">Silakan cek aplikasi pembayaran Anda.</p>
                    </div>
                @endif
            </div>

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

            <a href="{{ route('payment.check-status', $pembayaran->id) }}"
                class="mt-8 w-full py-4 bg-ajeng-black hover:bg-gray-800 text-ajeng-white font-bold rounded-xl shadow-md transition-all flex justify-center items-center gap-2">
                Saya Sudah Bayar / Cek Status
            </a>
        </div>
    </div>
</body>

</html>
