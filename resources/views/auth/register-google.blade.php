<x-landing-page-layout>
    <div class="flex items-center justify-center min-h-[80vh] px-4 py-12 md:py-16 font-poppins">
        <div class="w-full max-w-2xl bg-white p-8 md:p-10 rounded-4xl shadow-lg">

            <div class="text-center mb-8">
                <!-- Sapaan ramah menggunakan nama dari Google -->
                <h2 class="text-2xl md:text-3xl font-bold text-ajeng-black mb-2 tracking-tight">
                    Halo, {{ $google_name }}! 👋
                </h2>
                <p class="text-gray-500 text-sm md:text-base">
                    Tinggal satu langkah lagi. Lengkapi data di bawah ini untuk menyelesaikan pendaftaran Ajeng Laundry.
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4 md:gap-5">
                @csrf
                
                <input type="hidden" name="google_id" value="{{ $google_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    <!-- Nama Lengkap (Readonly) -->
                    <div>
                        <label for="nama" class="block text-sm font-semibold text-ajeng-black mb-2">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" value="{{ $google_name }}" readonly class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none">
                    </div>

                    <!-- Email (Readonly) -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-ajeng-black mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ $google_email }}" readonly class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    <!-- Username (Wajib Diisi) -->
                    <div>
                        <label for="username" class="block text-sm font-semibold text-ajeng-black mb-2">Username Baru</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus placeholder="Contoh: anangsetiaji" class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <!-- Nomor Telepon (Wajib Diisi) -->
                    <div>
                        <label for="nomor_telepon" class="block text-sm font-semibold text-ajeng-black mb-2">Nomor Whatsapp</label>
                        <input id="nomor_telepon" type="tel" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('nomor_telepon')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-ajeng-black mb-2">Buat Password</label>
                        <input id="password" type="password" name="password" required placeholder="Buat password akun" class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-ajeng-black mb-2">Ulangi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Konfirmasi password" class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Alamat (Wajib Diisi) -->
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-ajeng-black mb-2">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" required placeholder="Masukkan alamat lengkap penjemputan" class="w-full px-4 py-3 rounded-xl border border-ajeng-gray-3 focus:border-ajeng-pink focus:ring-ajeng-pink focus:outline-none transition-colors resize-none h-24">{{ old('alamat') }}</textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="w-full py-3.5 px-4 bg-ajeng-pink hover:bg-ajeng-bg-pink-1 text-white text-lg font-bold rounded-xl shadow-sm transition-all text-center cursor-pointer">
                        Simpan & Selesai
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-landing-page-layout>