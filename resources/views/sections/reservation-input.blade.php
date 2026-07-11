<section class="w-full px-4 md:px-8 py-6 font-poppins">
    <div class="flex flex-col items-center bg-ajeng-pink p-6 gap-4 rounded-4xl">
        <h1 class="md:self-start text-ajeng-white text-2xl md:text-4xl font-semibold">Reservasi Laundry</h1>
        <form action="" class="w-full grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4">
            <x-input type="text" name="name" placeholder="Nama" />
            <x-input type="text" name="name" placeholder="Alamat" />
            <x-input type="text" name="name" placeholder="Whatsapp" />
            <x-select name="layanan" required>
                <option value="" disabled selected class="text-ajeng-gray-2">-- Pilih Layanan Laundry --</option>
                <option value="cuci_kering">Cuci Kering</option>
                <option value="cuci_setrika">Cuci + Setrika</option>
                <option value="setrika_saja">Setrika Saja</option>
            </x-select>

            <x-datepicker name="tanggal_reservasi" required />
            <x-datepicker name="tanggal_ambil" required />

            <button type="submit"
                class="w-full bg-ajeng-white rounded-4xl px-4 py-3 text-ajeng-pink text-lg font-semibold">
                Buat Reservasi
            </button>
        </form>
    </div>
</section>
