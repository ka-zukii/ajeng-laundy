<x-landing-page-layout>

    <section class="bg-primary-50 text-slate-800 antialiased min-h-screen flex items-center justify-center">
        <div class="bg-primary-50 py-14 sm:py-20 px-4 w-full">
            <div class="max-w-xl mx-auto">

                {{-- Card --}}
                <div class="bg-white rounded-4xl shadow-xl shadow-primary/10 p-6 sm:p-10">

                    {{-- Pill badge --}}
                    <div class="flex justify-center">
                        <span
                            class="inline-block bg-ajeng-pink text-white text-xs font-semibold tracking-wide px-5 py-2 rounded-full">
                            Cek Cucian
                        </span>
                    </div>

                    {{-- Heading --}}
                    <h1 class="font-hand text-ajeng-pink text-center text-5xl sm:text-6xl mt-4 mb-2">
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
                                class="tab-btn text-sm font-semibold rounded-full py-3 transition-colors bg-ajeng-pink text-white shadow-sm"
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
                                class="absolute left-2 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-ajeng-pink text-white">

                                <span id="iconTransaksi" class="block">
                                    <x-heroicon-o-receipt-percent class="w-5 h-5" />
                                </span>

                                <span id="iconReservasi" class="hidden">
                                    <x-heroicon-o-phone class="w-5 h-5" />
                                </span>

                            </span>

                            <input type="text" name="keyword" id="inputField" value="{{ old('keyword') }}"
                                placeholder="Invoice ID pesanan kamu"
                                class="w-full border rounded-full py-3.5 pl-14 pr-5 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 transition-all
                                @error('keyword') border-red-400 focus:ring-red-400 focus:border-red-400 @else border-ajeng-gray-4 focus:border-ajeng-pink focus:ring-ajeng-pink/30 @enderror">
                        </div>

                        {{-- Menampilkan pesan error validasi Laravel --}}
                        @error('keyword')
                            <p class="text-red-500 text-xs mt-1 mb-4 ml-4 italic">{{ $message }}</p>
                        @else
                            <div class="mb-6"></div>
                        @enderror

                        {{-- Submit Button --}}
                        <button type="submit"
                            class="w-full bg-ajeng-pink hover:bg-ajeng-pink/60 text-white font-semibold text-sm rounded-full py-4 shadow-md shadow-primary/30 transition-colors">
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
                    <a href="{{ url('/layanan') }}" class="text-ajeng-pink font-semibold hover:underline">Laundry
                        Disini</a>
                </p>
            </div>
        </div>
    </section>
</x-landing-page-layout>
