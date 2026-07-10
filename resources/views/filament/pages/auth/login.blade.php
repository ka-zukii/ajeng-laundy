<div class="min-h-screen grid lg:grid-cols-2 bg-white">

    {{-- ========================================================= --}}
    {{-- KIRI --}}
    {{-- ========================================================= --}}
    <div
        class="relative hidden overflow-hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-[#FF7797] via-[#FF94AF] to-[#FFD5DF] text-white">

        {{-- Bubble --}}
        <div class="absolute inset-0 overflow-hidden">

            <div class="absolute top-10 left-20 w-24 h-24 rounded-full bg-white/10 blur-sm"></div>
            <div class="absolute top-1/3 right-16 w-40 h-40 rounded-full bg-white/10"></div>
            <div class="absolute bottom-24 left-12 w-32 h-32 rounded-full bg-white/10"></div>
            <div class="absolute bottom-12 right-32 w-20 h-20 rounded-full bg-white/20"></div>

        </div>

        <div class="relative z-10 text-center px-10">

            <img
                src="{{ asset('assets/logo-square.png') }}"
                class="mx-auto w-40 drop-shadow-xl mb-8"
            >

            <h1 class="text-5xl font-black tracking-wide">
                AJENG LAUNDRY
            </h1>

            <p class="mt-5 text-xl font-light leading-relaxed opacity-95">

                Sistem Manajemen Laundry modern
                untuk mengelola pelanggan,
                transaksi, pembayaran,
                hingga laporan dalam satu tempat.

            </p>

            <div class="mt-12 flex justify-center gap-3">

                <div class="rounded-full bg-white/20 px-5 py-2 backdrop-blur">
                    🧺 Cepat
                </div>

                <div class="rounded-full bg-white/20 px-5 py-2 backdrop-blur">
                    ✨ Bersih
                </div>

                <div class="rounded-full bg-white/20 px-5 py-2 backdrop-blur">
                    🌸 Wangi
                </div>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- KANAN --}}
    {{-- ========================================================= --}}
    <div class="flex items-center justify-center bg-gray-50">

        <div class="w-full max-w-md px-8">

            {{-- Logo Mobile --}}
            <div class="text-center lg:hidden mb-8">

                <img
                    src="{{ asset('assets/logo-square.png') }}"
                    class="mx-auto w-24"
                >

            </div>

            <div class="bg-white rounded-3xl shadow-2xl border border-pink-100 p-10">

                <div class="text-center mb-8">

                    <img
                        src="{{ asset('assets/logo-rectangle.png') }}"
                        class="h-12 mx-auto"
                    >

                    <h2 class="mt-6 text-3xl font-bold text-gray-800">

                        Selamat Datang 👋

                    </h2>

                    <p class="mt-2 text-gray-500">

                        Silakan login untuk melanjutkan.

                    </p>

                </div>

                <form wire:submit.prevent="authenticate" class="space-y-5">

                    {{-- Email --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <input
                            type="email"
                            wire:model="data.email"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-[#FF7797] focus:ring-[#FF7797]"
                            placeholder="admin@ajenglaundry.com"
                        >

                        @error('data.email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- Password --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Password
                        </label>

                        <input
                            type="password"
                            wire:model="data.password"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-[#FF7797] focus:ring-[#FF7797]"
                            placeholder="••••••••"
                        >

                        @error('data.password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="flex items-center">

                        <input
                            type="checkbox"
                            wire:model="data.remember"
                            class="rounded border-gray-300 text-[#FF7797] focus:ring-[#FF7797]"
                        >

                        <span class="ml-2 text-sm text-gray-600">

                            Ingat saya

                        </span>

                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="w-full rounded-xl bg-[#FF7797] py-3 font-semibold text-white transition hover:bg-[#ff5d86]"
                    >

                        <span wire:loading.remove>
                            Masuk ke Dashboard
                        </span>

                        <span wire:loading>
                            Memproses...
                        </span>

                    </button>

                </form>

            </div>

            <div class="mt-8 text-center text-sm text-gray-500">

                © {{ now()->year }} Ajeng Laundry

            </div>

        </div>

    </div>

</div>