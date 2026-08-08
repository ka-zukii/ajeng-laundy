<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-800">Ubah Password</h3>
        <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak
            agar tetap aman.</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
            <input type="password" name="current_password" required autocomplete="current-password"
                class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-gray-200 focus:border-ajeng-pink outline-none transition-all">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
            <input type="password" name="password" required autocomplete="new-password"
                class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-gray-200 focus:border-ajeng-pink outline-none transition-all">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-gray-200 focus:border-ajeng-pink outline-none transition-all">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="px-6 py-3 bg-ajeng-pink text-white font-semibold rounded-xl hover:bg-ajeng-pink/80 transition-colors shadow-sm text-sm cursor-pointer">
                Perbarui Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</div>
