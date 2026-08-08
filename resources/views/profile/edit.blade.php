<x-pelanggan-layout>
    <x-slot:title>
        Profil Pelanggan - Ajeng Laundry
    </x-slot>

    <div class="w-full px-4 py-10 sm:px-8 md:px-16 font-poppins">
        <div class="max-w-3xl mx-auto space-y-8">

            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Pengaturan Profil</h2>
                <p class="text-gray-500 mt-2 text-sm md:text-base">
                    Perbarui informasi data diri dan pengaturan keamanan akun Anda.
                </p>
            </div>

            @include('profile.partials.update-profile-information')
            @include('profile.partials.update-password')
            @include('profile.partials.delete-account')
        </div>
    </div>
</x-pelanggan-layout>
