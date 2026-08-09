@props(['transaksi'])

<div id="paymentModal" class="fixed inset-0 z-50 flex items-end sm:items-center justify-center hidden opacity-0 transition-opacity duration-300">

    <div class="absolute inset-0 bg-ajeng-black/60 backdrop-blur-sm" onclick="closeModal()"></div>

    <div class="relative w-full max-w-lg bg-ajeng-white rounded-t-3xl sm:rounded-3xl shadow-2xl p-6 sm:p-8 transform translate-y-full sm:translate-y-10 transition-transform duration-300 max-h-[90vh] overflow-y-auto hide-scrollbar" id="modalContent">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-ajeng-black">Pilih Pembayaran</h3>
            <button type="button" onclick="closeModal()" class="p-2 bg-ajeng-gray-5 text-ajeng-gray-2 hover:text-ajeng-pink rounded-full transition-colors">
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>

        <form action="{{ route('payment.proses', $transaksi->id) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <h4 class="text-xs font-bold text-ajeng-gray-2 uppercase tracking-wider mb-3">E-Wallet</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="metode" value="gopay" class="peer sr-only" required>
                        <div class="p-4 rounded-xl border-2 border-ajeng-gray-4 group-hover:border-ajeng-pink/50 peer-checked:border-ajeng-pink peer-checked:bg-ajeng-bg-pink-1 transition-all flex items-center justify-between">
                            <span class="font-bold text-ajeng-black">GoPay</span>
                            <x-heroicon-s-device-phone-mobile class="w-6 h-6 text-ajeng-gray-3 peer-checked:text-ajeng-pink" />
                        </div>
                    </label>
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="metode" value="shopeepay" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-ajeng-gray-4 group-hover:border-ajeng-pink/50 peer-checked:border-ajeng-pink peer-checked:bg-ajeng-bg-pink-1 transition-all flex items-center justify-between">
                            <span class="font-bold text-ajeng-black">ShopeePay</span>
                            <x-heroicon-s-device-phone-mobile class="w-6 h-6 text-ajeng-gray-3 peer-checked:text-ajeng-pink" />
                        </div>
                    </label>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-ajeng-gray-2 uppercase tracking-wider mb-3">Scan QR Code</h4>
                <label class="relative cursor-pointer group">
                    <input type="radio" name="metode" value="qris" class="peer sr-only">
                    <div class="p-4 rounded-xl border-2 border-ajeng-gray-4 group-hover:border-ajeng-pink/50 peer-checked:border-ajeng-pink peer-checked:bg-ajeng-bg-pink-1 transition-all flex items-center justify-between">
                        <div>
                            <span class="block font-bold text-ajeng-black">QRIS</span>
                            <span class="block text-xs text-ajeng-gray-1 mt-0.5">Semua Mobile Banking & E-Wallet</span>
                        </div>
                        <x-heroicon-s-qr-code class="w-7 h-7 text-ajeng-gray-3 peer-checked:text-ajeng-pink" />
                    </div>
                </label>
            </div>

            <div>
                <h4 class="text-xs font-bold text-ajeng-gray-2 uppercase tracking-wider mb-3">Transfer Bank (Virtual Account)</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="metode" value="bca_va" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-ajeng-gray-4 group-hover:border-ajeng-pink/50 peer-checked:border-ajeng-pink peer-checked:bg-ajeng-bg-pink-1 transition-all flex items-center justify-between">
                            <span class="font-bold text-ajeng-black">BCA</span>
                            <x-heroicon-s-building-library class="w-6 h-6 text-ajeng-gray-3 peer-checked:text-ajeng-pink" />
                        </div>
                    </label>
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="metode" value="mandiri_va" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-ajeng-gray-4 group-hover:border-ajeng-pink/50 peer-checked:border-ajeng-pink peer-checked:bg-ajeng-bg-pink-1 transition-all flex items-center justify-between">
                            <span class="font-bold text-ajeng-black">Mandiri</span>
                            <x-heroicon-s-building-library class="w-6 h-6 text-ajeng-gray-3 peer-checked:text-ajeng-pink" />
                        </div>
                    </label>
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="metode" value="bni_va" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-ajeng-gray-4 group-hover:border-ajeng-pink/50 peer-checked:border-ajeng-pink peer-checked:bg-ajeng-bg-pink-1 transition-all flex items-center justify-between">
                            <span class="font-bold text-ajeng-black">BNI</span>
                            <x-heroicon-s-building-library class="w-6 h-6 text-ajeng-gray-3 peer-checked:text-ajeng-pink" />
                        </div>
                    </label>
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="metode" value="bri_va" class="peer sr-only">
                        <div class="p-4 rounded-xl border-2 border-ajeng-gray-4 group-hover:border-ajeng-pink/50 peer-checked:border-ajeng-pink peer-checked:bg-ajeng-bg-pink-1 transition-all flex items-center justify-between">
                            <span class="font-bold text-ajeng-black">BRI</span>
                            <x-heroicon-s-building-library class="w-6 h-6 text-ajeng-gray-3 peer-checked:text-ajeng-pink" />
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-ajeng-gray-4/50">
                <button type="submit" class="w-full py-4 bg-ajeng-black hover:bg-gray-800 text-ajeng-white font-bold rounded-xl shadow-md transition-all flex justify-center items-center gap-2">
                    Lanjutkan Pembayaran
                    <x-heroicon-m-arrow-right class="w-5 h-5" />
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('paymentModal');
    const modalContent = document.getElementById('modalContent');

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('translate-y-full', 'sm:translate-y-10');
            modalContent.classList.add('translate-y-0');
        }, 10);
    }

    function closeModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('translate-y-0');
        modalContent.classList.add('translate-y-full', 'sm:translate-y-10');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }

    const style = document.createElement('style');
    style.innerHTML = `
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    `;
    document.head.appendChild(style);
</script>
