<section class="w-full py-6 font-poppins">
    <div class="flex 2xl:max-w-7xl 2xl:mx-auto flex-col items-center bg-ajeng-pink p-6 gap-4 rounded-4xl drop-shadow-xl">
        <h1 class="md:self-start text-ajeng-white text-2xl md:text-4xl font-semibold">Reservasi Laundry</h1>
        <form action="{{ route('reservation.store') }}" class="w-full grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4"
            method="POST">
            @csrf
            <x-input type="text" name="name" placeholder="Nama" />
            <x-input type="text" name="address" placeholder="Alamat" />
            <x-input type="text" name="whatsapp-number" placeholder="Whatsapp" />

            <x-select name="layanan" required>
                <option value="" disabled selected class="text-ajeng-gray-2">Pilih Layanan Laundry</option>
                @foreach ($layanans as $layanan)
                    <option value="{{ $layanan->id }}" class="text-ajeng-gray-2">
                        {{ $layanan->nama_layanan }}
                    </option>
                @endforeach
            </x-select>

            <x-datepicker name="date_picker" placeholder="Tanggal Penjemputan" required />
            <x-timepicker name="time_picker" placeholder="Jam Penjemputan" required />

            <button type="submit"
                class="max-w-60 bg-ajeng-white rounded-4xl px-4 py-3 text-ajeng-pink text-lg font-semibold hover:bg-ajeng-bg-pink-1 transition-all cursor-pointer">
                Buat Reservasi
            </button>
        </form>
    </div>
</section>
