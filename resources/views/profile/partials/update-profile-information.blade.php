<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-800">Informasi Profil</h3>
        <p class="text-sm text-gray-500">Perbarui nama pengguna dan alamat email akun Anda.</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-ajeng-pink outline-none transition-all">
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-ajeng-pink outline-none transition-all">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="px-6 py-3 bg-ajeng-pink text-white font-semibold rounded-xl hover:hover:bg-ajeng-pink/80 transition-colors shadow-sm text-sm cursor-pointer">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</div>
