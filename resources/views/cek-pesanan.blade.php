<x-layout>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cek Cucian Kamu - Ajeng Laundry</title>

        {{-- Tailwind CSS (CDN for prototyping) --}}
        <script src="https://cdn.tailwindcss.com"></script>

        {{-- Google Fonts: Poppins (secion) & Caveat (handwritten heading) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Caveat:wght@500;600;700&display=swap"
            rel="stylesheet">

        {{-- FontAwesome Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
            integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
            crossorigin="anonymous" referrerpolicy="no-referrer">

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Poppins', 'sans-serif'],
                            hand: ['Caveat', 'cursive'],
                        },
                        colors: {
                            primary: {
                                DEFAULT: '#E37691',
                                50: '#FDF8F9',
                                100: '#FBEFF2',
                                600: '#D9607E',
                            },
                        },
                    },
                },
            }
        </script>

        <style>
            secion {
                font-family: 'Poppins', sans-serif;
            }

            .font-hand {
                font-family: 'Caveat', cursive;
            }
        </style>
    </head>

    <secion class="bg-primary-50 text-slate-800 antialiased">
        {{-- ============ MAIN CONTENT ============ --}}
        <div class="bg-primary-50 py-14 sm:py-20 px-4">
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

                    <form action="" method="POST">
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
                        <input type="hidden" name="tipe_pencarian" id="tipePencarian" value="transaksi">

                        {{-- Input Field --}}
                        <div class="relative mb-6">
                            <span
                                class="absolute left-2 top-1/6 -translate-y-1/6 w-9 h-9 flex items-center justify-center rounded-full bg-primary-100 text-primary">
                                <i class="fa-solid fa-receipt text-sm"></i>
                            </span>
                            <!-- Menambahkan id="inputField" di sini -->
                            <input type="text" name="invoice_id" id="inputField"
                                placeholder="Invoice ID pesanan kamu"
                                class="w-full border border-primary/40 rounded-full py-3.5 pl-14 pr-5 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
                        </div>

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
                            halaman
                            pelanggan.
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

        {{-- ============ SCRIPTS ============ --}}
        <script>
            // Tab switching (Cek Reservasi / Cek Transaksi)
            function switchTab(tab) {
                const tabReservasi = document.getElementById('tabReservasi');
                const tabTransaksi = document.getElementById('tabTransaksi');
                const tipePencarian = document.getElementById('tipePencarian');
                const inputField = document.getElementById('inputField'); // Mengambil elemen input

                const activeClasses = ['bg-primary', 'text-white', 'shadow-sm'];
                const inactiveClasses = ['text-slate-500', 'hover:text-slate-700'];

                if (tab === 'reservasi') {
                    tabReservasi.classList.add(...activeClasses);
                    tabReservasi.classList.remove(...inactiveClasses);
                    tabReservasi.setAttribute('aria-selected', 'true');

                    tabTransaksi.classList.remove(...activeClasses);
                    tabTransaksi.classList.add(...inactiveClasses);
                    tabTransaksi.setAttribute('aria-selected', 'false');

                    // Mengubah placeholder saat tab reservasi aktif
                    inputField.placeholder = 'Masukkan nomor telepon';
                } else {
                    tabTransaksi.classList.add(...activeClasses);
                    tabTransaksi.classList.remove(...inactiveClasses);
                    tabTransaksi.setAttribute('aria-selected', 'true');

                    tabReservasi.classList.remove(...activeClasses);
                    tabReservasi.classList.add(...inactiveClasses);
                    tabReservasi.setAttribute('aria-selected', 'false');

                    // Mengembalikan placeholder saat tab transaksi aktif
                    inputField.placeholder = 'Invoice ID pesanan kamu';
                }

                tipePencarian.value = tab;
            }
        </script>
    </secion>

</x-layout>
