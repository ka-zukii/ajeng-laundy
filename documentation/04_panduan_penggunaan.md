# Panduan Penggunaan Sistem (User Manual)

Sistem Informasi **Sipakar Laundry** dirancang dengan antarmuka yang intuitif baik untuk sisi Pelanggan (_Frontend_) maupun sisi Pengelola/Admin (_Backend_ menggunakan Filament PHP). Sistem ini sangat fleksibel dan mendukung transaksi baik secara _Online_ maupun _Offline_ (langsung di gerai).

Berikut adalah panduan alur kerja dan penggunaan fitur-fitur utama di dalam sistem.

---

## 1. Alur Pemesanan (Online & Offline)

Sistem mengakomodasi dua jenis metode pemesanan pelanggan:

### A. Alur Pemesanan Online (Penjemputan)

1. Pelanggan mengakses halaman utama (_Landing Page_).
2. Pelanggan **tidak diwajibkan untuk login**. Pelanggan dapat langsung memilih menu **Buat Pesanan/Reservasi** dan mengisi form identitas dasar (Nama, No. WA, Alamat).
   _(Catatan: Fitur Login/Register tetap disediakan murni untuk mempermudah pelanggan melacak riwayat transaksi mereka kapan saja)._
3. Pelanggan memilih jenis layanan dan menentukan tanggal penjemputan pakaian.
4. Status awal pesanan di sistem adalah **"Menunggu Penjemputan"**.
5. Admin memantau menu **Reservasi** di Dashboard, lalu setelah kurir menjemput pakaian, Admin menekan tombol **Proses Transaksi**.
6. Admin memasukkan data aktual cucian (berat/jumlah, tingkat kekotoran, noda).
7. **Mesin Fuzzy Logic** memproses estimasi waktu dan prioritas, lalu pesanan resmi menjadi data **Transaksi** aktif.

### B. Alur Pemesanan Offline (Langsung di Gerai / Walk-in)

1. Pelanggan datang langsung ke gerai laundry dengan membawa pakaian.
2. Admin membuka Dashboard Filament dan langsung menuju menu **Transaksi** (mengabaikan menu Reservasi).
3. Admin menekan tombol **Create Transaksi** atau **New Record**.
4. Admin mengisi nama pelanggan baru (atau memilih data pelanggan yang sudah ada), lalu langsung menginput detail cucian (berat/jumlah, noda, tingkat kekotoran).
5. Saat disimpan, **Mesin Fuzzy Logic** akan otomatis bekerja menetapkan waktu selesai dan prioritas pencucian.

---

## 2. Fitur Cetak Invoice PDF

Aplikasi ini dilengkapi dengan fitur pembuatan faktur (Invoice) digital berbasis PDF menggunakan _library_ DomPDF.

**Cara Penggunaan (Bagi Admin):**

1. Buka menu **Transaksi** di Dashboard Admin.
2. Pada tabel daftar transaksi, lihat pada kolom aksi (sebelah kanan) di setiap baris data.
3. Klik tombol **Cetak** (ikon _printer_ warna kuning).
4. File PDF akan otomatis di-generate menggunakan format khusus. Invoice fisik ini bisa langsung dicetak dan diberikan kepada pelanggan _offline_ yang datang ke gerai.

**Cara Penggunaan (Bagi Pelanggan Online):**

1. Pelanggan memasukkan nomor resi pesanan di halaman utama atau melihatnya di menu **Pesanan Saya** (jika login).
2. Klik tombol **Download Invoice** berwarna biru.
3. Pelanggan akan mendapatkan salinan digital (PDF) dari tagihan cucian mereka.
