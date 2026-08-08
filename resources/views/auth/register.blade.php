<x-landing-page-layout>
    <div class="flex items-center justify-center min-h-[80vh] px-4 py-12 md:py-16">
        <div class="w-full max-w-2xl bg-white p-8 md:p-10 rounded-4xl shadow-lg font-poppins">

            <h2 class="text-2xl md:text-3xl font-bold text-center text-ajeng-black mb-2 tracking-tight">
                Buat Akun Pelanggan
            </h2>
            <p class="text-center text-gray-500 mb-8 text-sm md:text-base">
                Daftarkan diri Anda untuk melihat status cucian dan riwayat transaksi.
            </p>

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4 md:gap-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-ajeng-black mb-2">Nama
                            Lengkap</label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required
                            autofocus placeholder="Nama sesuai KTP"
                            class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-ajeng-black mb-2">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required
                            placeholder="Contoh: anangsetiaji"
                            class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-ajeng-black mb-2">Alamat
                            Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="Email aktif"
                            class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Nomor Telepon / Whatsapp -->
                    <div>
                        <label for="nomor_telepon" class="block text-sm font-semibold text-ajeng-black mb-2">Nomor
                            Whatsapp</label>
                        <input id="nomor_telepon" type="tel" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                            required placeholder="Contoh: 081234567890"
                            class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('nomor_telepon')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-ajeng-black mb-2">Password</label>
                        <input id="password" type="password" name="password" required placeholder="Buat password"
                            class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-semibold text-ajeng-black mb-2">Ulangi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            placeholder="Konfirmasi password"
                            class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Alamat (Teks Panjang) -->
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-ajeng-black mb-2">Alamat
                        Lengkap</label>
                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap"
                        class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors resize-none h-24">{{ old('alamat') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit"
                        class="w-full py-3.5 px-4 bg-ajeng-pink hover:bg-ajeng-bg-pink-1 text-white text-lg font-bold rounded-xl shadow-sm transition-all text-center cursor-pointer">
                        Daftar Akun Sekarang
                    </button>
                </div>

                <div class="mt-2 flex items-center justify-center gap-4">
                    <hr class="w-full border-ajeng-gray-3">
                    <span class="text-sm text-gray-400 font-medium">ATAU</span>
                    <hr class="w-full border-ajeng-gray-3">
                </div>

                <a href="{{ route('google.login') }}"
                    class="flex w-full items-center justify-center gap-3 rounded-xl border border-ajeng-gray-3 bg-white px-4 py-3.5 font-semibold text-ajeng-black hover:bg-gray-50 transition shadow-sm text-lg">
                    <svg class="h-6 w-6" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Daftar dengan Google
                </a>

                <!-- Link Login -->
                <div class="text-center mt-2">
                    <span class="text-sm text-gray-500">Sudah punya akun? </span>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-ajeng-pink hover:underline">Masuk
                        di sini</a>
                </div>

            </form>
        </div>
    </div>
</x-landing-page-layout>
