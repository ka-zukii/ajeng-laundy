<x-layout>
    <!-- Wrapper utama halaman, diberi background pink-50 (#fdf2f8) -->
    <div class="min-h-screen bg-[#fdf2f8] p-4 sm:p-8 flex items-center justify-center" style="font-family: 'Poppins', sans-serif;">

        <!-- Container Utama -->
        <div class="bg-white w-full max-w-6xl rounded-4xl shadow-sm border border-pink-50 p-8 md:p-10">
            
            <!-- Judul -->
            <h2 class="text-3xl font-semibold text-[#f472b6] mb-8 tracking-wide">Daftar Pesanan</h2>

            <!-- Wrapper Tabel untuk Responsivitas -->
            <div class="overflow-x-auto">
                <!-- border-separate dan border-spacing-0 penting agar radius di thead bisa bekerja -->
                <table class="w-full text-left border-separate border-spacing-0 min-w-200">
                    <thead>
                        <tr class="bg-[#f472b6] text-white">
                            <th class="py-4 px-6 font-medium rounded-l-full">Invoice</th>
                            <th class="py-4 px-4 font-medium">Tanggal</th>
                            <th class="py-4 px-4 font-medium">Total Pembayaran</th>
                            <th class="py-4 px-4 font-medium">Pembayaran</th>
                            <th class="py-4 px-4 font-medium">Laundry</th>
                            <th class="py-4 px-4 font-medium">Reservasi</th>
                            <th class="py-4 px-6 font-medium rounded-r-full">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <!-- Baris 1 -->
                        <tr>
                            <td class="py-4 px-6 text-[#f472b6] font-medium border-b border-pink-100">AJL-20260627-B7N2Q8</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">25 - Jun - 2026</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Rp 25.000</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Menunggu</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Pending</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Online</td>
                            <td class="py-4 px-6 border-b border-pink-100">
                                <a href="#" class="text-[#f472b6] font-medium hover:text-pink-600 hover:underline transition">Detail</a>
                            </td>
                        </tr>
                        <!-- Baris 2 -->
                        <tr>
                            <td class="py-4 px-6 text-[#f472b6] font-medium border-b border-pink-100">AJL-20260627-R4X1M9</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">17 - Jun -2026</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Rp 35.000</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Sukses</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Diproses</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Online</td>
                            <td class="py-4 px-6 border-b border-pink-100">
                                <a href="#" class="text-[#f472b6] font-medium hover:text-pink-600 hover:underline transition">Detail</a>
                            </td>
                        </tr>
                        <!-- Baris 3 -->
                        <tr>
                            <td class="py-4 px-6 text-[#f472b6] font-medium border-b border-pink-100">AJL-20260627-K8P5T2</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">12 - Mar - 2026</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Rp 15.000</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Sukses</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Selesai</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Offline</td>
                            <td class="py-4 px-6 border-b border-pink-100">
                                <a href="#" class="text-[#f472b6] font-medium hover:text-pink-600 hover:underline transition">Detail</a>
                            </td>
                        </tr>
                        <!-- Baris 4 -->
                        <tr>
                            <td class="py-4 px-6 text-[#f472b6] font-medium border-b border-pink-100">AJL-20260627-W3J7F6</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">7 - Mar - 2026</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Rp 50.000</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Sukses</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Selesai</td>
                            <td class="py-4 px-4 text-gray-700 border-b border-pink-100">Offline</td>
                            <td class="py-4 px-6 border-b border-pink-100">
                                <a href="#" class="text-[#f472b6] font-medium hover:text-pink-600 hover:underline transition">Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-center gap-3 mt-10">
                <!-- Tombol Previous -->
                <button class="w-10 h-10 rounded-full border border-[#f472b6] bg-pink-100 text-[#f472b6] flex items-center justify-center hover:bg-[#f472b6] hover:text-white transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                
                <!-- Halaman Aktif -->
                <button class="w-10 h-10 rounded-full bg-[#f8a5c2] text-white border border-[#f8a5c2] flex items-center justify-center font-medium shadow-sm">
                    1
                </button>
                
                <!-- Halaman Tidak Aktif -->
                <button class="w-10 h-10 rounded-full border border-[#f472b6] text-[#f472b6] flex items-center justify-center font-medium hover:bg-pink-50 transition duration-200">
                    2
                </button>
                
                <!-- Tombol Next -->
                <button class="w-10 h-10 rounded-full border border-[#f472b6] bg-pink-100 text-[#f472b6] flex items-center justify-center hover:bg-[#f472b6] hover:text-white transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

        </div>
    </div>
</x-layout>