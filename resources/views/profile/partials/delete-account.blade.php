<div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-red-600">Hapus Akun</h3>
        <p class="text-sm text-gray-500">Setelah akun dihapus, semua sumber daya dan datanya akan dihapus
            secara permanen.</p>
    </div>

    <div x-data="{ open: false }">
        <button @click="open = true"
            class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors shadow-sm text-sm cursor-pointer">
            Hapus Akun Secara Permanen
        </button>

        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-ajeng-dark-2/60 backdrop-blur-sm px-4"
            x-cloak>
            <div @click.away="open = false" class="bg-white rounded-2xl p-6 sm:p-8 max-w-md w-full shadow-xl"
                x-transition>
                <h2 class="text-lg font-bold text-gray-900 mb-2">Apakah Anda yakin?</h2>
                <p class="text-sm text-gray-500 mb-6">
                    Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini
                    secara permanen.
                </p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <input type="password" name="password" placeholder="Password Anda" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-400 outline-none transition-all mb-6">

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors text-sm">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors text-sm shadow-sm cursor-pointer">
                            Ya, Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
