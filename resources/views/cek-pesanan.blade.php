<x-layout>

    <section class="bg-primary-50 text-slate-800 antialiased min-h-screen flex items-center justify-center">
        <div class="bg-primary-50 py-14 sm:py-20 px-4 w-full">
            <div class="max-w-xl mx-auto">

                {{-- Card --}}
                <div class="bg-white rounded-4xl shadow-xl shadow-primary/10 p-6 sm:p-10">

                    {{-- Pill badge --}}
                    <div class="flex justify-center">
                        <span
                            class="inline-block bg-primary text-white text-xs font-semibold tracking-wide px-5 py-2 rounded-full">
                            Cek Cucian
                        </span>
                    </div>

                    {{-- Heading --}}
                    <h1 class="font-hand text-primary text-center text-5xl sm:text-6xl mt-4 mb-2">
                        Cek Cucian Kamu !
                    </h1>

                    {{-- Subheading --}}
                    <p class="text-center text-slate-500 text-sm sm:text-base font-medium mb-8">
                        Cucian kamu dapat di proses setelah kamu memesan ya
                    </p>

                    {{-- ACTION diubah ke route baru pencarian --}}
                    <form action="{{ route('pesanan.proses') }}" method="POST">
                        @csrf

                        {{-- Toggle Tabs --}}
                        <div class="grid grid-cols-2 gap-1 bg-slate-100 rounded-full p-1.5 mb-6" role="tablist">
                            <button type="button" id="tabReservasi" onclick="switchTab('reservasi')"
                                class="tab-btn text-sm font-semibold rounded-full py-3 transition-colors text-slate-500 hover:text-slate-700"
                                role="tab" aria-selected="false">
                                Cek Reservasi
                            </button>
                            <button type="button" id="tabTransaksi" onclick="switchTab('transaksi')"
                                class="tab-btn text-sm font-semibold rounded-full py-3 transition-colors bg-primary text-white shadow-sm"
                                role="tab" aria-selected="true">
                                Cek Transaksi
                            </button>
                        </div>

                        {{-- Value default mengikuti tab yang sedang aktif (transaksi) --}}
                        <input type="hidden" name="tipe_pencarian" id="tipePencarian"
                            value="{{ old('tipe_pencarian', 'transaksi') }}">

                        {{-- Input Field --}}
                        <div class="relative mb-2">
                            <span
                                class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-primary-100 text-primary">
                                <i class="fa-solid fa-receipt text-sm"></i>
                            </span>

                            {{-- NAME diubah jadi "keyword", value dipertahankan saat validasi error --}}
                            <input type="text" name="keyword" id="inputField" value="{{ old('keyword') }}"
                                placeholder="Invoice ID pesanan kamu"
                                class="w-full border @error('keyword') border-red-400 focus:ring-red-400 focus:border-red-400 @else @enderror rounded-full py-3.5 pl-14 pr-5 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 transition-all">
                        </div>

                        {{-- Menampilkan pesan error validasi Laravel --}}
                        @error('keyword')
                            <p class="text-red-500 text-xs mt-1 mb-4 ml-4 italic">{{ $message }}</p>
                        @else
                            <div class="mb-6"></div>
                        @enderror

                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full bg-primary hover:bg-primary-600 text-white font-semibold text-sm rounded-full py-4 shadow-md shadow-primary/30 transition-colors">
                            Cek Pesanan ku
                        </button>
                    </form>

                    {{-- Note box --}}
                    <div class="mt-6 bg-primary-50 rounded-2xl p-4 flex items-start gap-3">
                        <span class="text-2xl leading-none shrink-0" aria-hidden="true">🧺</span>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            <span class="font-bold text-slate-600">Catatan:</span>
                            Kalau sudah punya akun, langsung login aja ya! Riwayat transaksi kamu bisa dilihat di
                            halaman pelanggan.
                        </p>
                    </div>
                </div>

                {{-- Below-card link --}}
                <p class="text-center text-sm font-medium text-slate-700 mt-6">
                    Belum memesan ?
                    <a href="{{ url('/layanan') }}" class="text-primary font-semibold hover:underline">Laundry
                        Disini</a>
                </p>
            </div>
        </div>
    </section>

    {{-- Script JS --}}
    <script>
        function switchTab(tab) {
            const tabReservasi = document.getElementById('tabReservasi');
            const tabTransaksi = document.getElementById('tabTransaksi');
            const tipePencarian = document.getElementById('tipePencarian');
            const inputField = document.getElementById('inputField');

            const activeClasses = ['bg-primary', 'text-white', 'shadow-sm'];
            const inactiveClasses = ['text-slate-500', 'hover:text-slate-700'];

            if (tab === 'reservasi') {
                tabReservasi.classList.add(...activeClasses);
                tabReservasi.classList.remove(...inactiveClasses);
                tabReservasi.setAttribute('aria-selected', 'true');

                tabTransaksi.classList.remove(...activeClasses);
                tabTransaksi.classList.add(...inactiveClasses);
                tabTransaksi.setAttribute('aria-selected', 'false');

                inputField.placeholder = 'Masukkan nomor telepon WhatsApp';
                inputField.type = 'number'; // Mengubah keyboard HP jadi angka
            } else {
                tabTransaksi.classList.add(...activeClasses);
                tabTransaksi.classList.remove(...inactiveClasses);
                tabTransaksi.setAttribute('aria-selected', 'true');

                tabReservasi.classList.remove(...activeClasses);
                tabReservasi.classList.add(...inactiveClasses);
                tabReservasi.setAttribute('aria-selected', 'false');

                inputField.placeholder = 'Invoice ID pesanan kamu';
                inputField.type = 'text'; // Mengubah keyboard HP jadi normal
            }

            tipePencarian.value = tab;
        }

        // Menjaga agar tampilan form (tab) sesuai saat di-redirect kembali akibat validasi error
        window.addEventListener('load', () => {
            const currentTab = document.getElementById('tipePencarian').value;
            switchTab(currentTab);
        });
    </script>

</x-layout>
