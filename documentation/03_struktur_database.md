# Struktur Database & Kamus Data (Data Dictionary)

Sistem Informasi Sipakar Laundry menggunakan skema database relasional. Berikut adalah rincian struktur dari setiap tabel penyusun sistem beserta tipe data dan keterangannya berdasarkan definisi model dan kebutuhan sistem.

---

## 1. Rincian Tabel Master

### Tabel `users`

Tabel `users` digunakan untuk menyimpan data akun pengguna, kredensial sistem, serta hak akses pengguna terhadap aplikasi.

| Nama Kolom                 | Tipe Data   | Keterangan                                     |
| :------------------------- | :---------- | :--------------------------------------------- |
| `id`                       | BigInt (PK) | Primary key bawaan Laravel                     |
| `username`                 | Varchar     | Nama pengguna untuk login                      |
| `email`                    | Varchar     | Alamat surel pengguna dan bersifat unik        |
| `email_verified_at`        | DateTime    | Waktu verifikasi alamat surel                  |
| `password`                 | Varchar     | Kata sandi pengguna yang telah di-hash         |
| `role`                     | Enum        | Hak akses pengguna berdasarkan `UserRole` Enum |
| `remember_token`           | Varchar     | Token untuk mempertahankan sesi login          |
| `created_at`, `updated_at` | Timestamp   | Waktu pembuatan dan perubahan data             |

### Tabel `layanan`

Tabel `layanan` digunakan untuk mengelola daftar paket atau jasa laundry yang tersedia pada sistem.

| Nama Kolom                 | Tipe Data   | Keterangan                                                                              |
| :------------------------- | :---------- | :-------------------------------------------------------------------------------------- |
| `id`                       | BigInt (PK) | Primary key                                                                             |
| `nama_layanan`             | Varchar     | Nama paket atau jasa laundry                                                            |
| `jenis_perhitungan`        | Enum        | Jenis perhitungan layanan berdasarkan `JenisPerhitungan` Enum, yaitu kiloan atau satuan |
| `biaya_layanan`            | Decimal     | Harga dasar layanan                                                                     |
| `created_at`, `updated_at` | Timestamp   | Waktu pembuatan dan perubahan data                                                      |

### Tabel `noda_pakaian`

Tabel `noda_pakaian` digunakan sebagai data referensi atau _knowledge base_ mengenai jenis noda pada pakaian, solusi penanganannya, serta biaya tambahan yang dikenakan.

| Nama Kolom                 | Tipe Data   | Keterangan                           |
| :------------------------- | :---------- | :----------------------------------- |
| `id`                       | BigInt (PK) | Primary key                          |
| `nama_noda`                | Varchar     | Jenis noda pada pakaian              |
| `solusi`                   | Text        | Cara atau solusi penanganan noda     |
| `biaya_tambahan`           | Decimal     | Biaya tambahan untuk penanganan noda |
| `created_at`, `updated_at` | Timestamp   | Waktu pembuatan dan perubahan data   |

---

## 2. Rincian Tabel Transaksional

### Tabel `pelanggan`

Tabel `pelanggan` digunakan untuk menyimpan data identitas pelanggan yang menggunakan layanan laundry.

| Nama Kolom                 | Tipe Data   | Keterangan                                                                                         |
| :------------------------- | :---------- | :------------------------------------------------------------------------------------------------- |
| `id`                       | BigInt (PK) | Primary key                                                                                        |
| `user_id`                  | BigInt (FK) | Foreign key yang merujuk ke tabel `users`, bersifat opsional apabila pelanggan tidak memiliki akun |
| `nama`                     | Varchar     | Nama lengkap pelanggan                                                                             |
| `nomor_telepon`            | Varchar     | Nomor telepon atau WhatsApp pelanggan                                                              |
| `alamat`                   | Text        | Alamat tempat tinggal atau alamat penjemputan                                                      |
| `created_at`, `updated_at` | Timestamp   | Waktu pembuatan dan perubahan data                                                                 |

### Tabel `reservation`

Tabel `reservation` digunakan untuk mencatat permintaan atau antrean penjemputan pakaian dari pelanggan.

| Nama Kolom                 | Tipe Data   | Keterangan                                                                                              |
| :------------------------- | :---------- | :------------------------------------------------------------------------------------------------------ |
| `id`                       | BigInt (PK) | Primary key                                                                                             |
| `pelanggan_id`             | BigInt (FK) | Foreign key yang merujuk ke tabel `pelanggan`                                                           |
| `layanan_id`               | BigInt (FK) | Foreign key yang merujuk ke tabel `layanan` yang dipesan                                                |
| `transaksi_id`             | BigInt (FK) | Foreign key yang merujuk ke tabel `transaksi`, diisi apabila reservasi telah diproses menjadi transaksi |
| `tanggal_penjemputan`      | DateTime    | Jadwal pengambilan pakaian oleh kurir                                                                   |
| `status_reservation`       | Enum        | Status reservasi berdasarkan `StatusReservation` Enum                                                   |
| `created_at`, `updated_at` | Timestamp   | Waktu pembuatan dan perubahan data                                                                      |

### Tabel `transaksi`

Tabel `transaksi` merupakan tabel utama yang menyimpan informasi pesanan dan proses operasional laundry.

| Nama Kolom                 | Tipe Data   | Keterangan                                                               |
| :------------------------- | :---------- | :----------------------------------------------------------------------- |
| `id`                       | BigInt (PK) | Primary key                                                              |
| `pelanggan_id`             | BigInt (FK) | Foreign key yang merujuk ke tabel `pelanggan`                            |
| `kode_transaksi`           | Varchar     | Nomor atau kode faktur yang dibuat oleh sistem, contohnya AJL-...        |
| `tanggal_masuk`            | DateTime    | Waktu pesanan dicatat ke dalam sistem                                    |
| `tanggal_selesai`          | DateTime    | Waktu aktual pesanan selesai                                             |
| `estimasi_selesai`         | DateTime    | Waktu perkiraan penyelesaian yang diperoleh dari perhitungan Fuzzy Logic |
| `status_laundry`           | Enum        | Status proses laundry berdasarkan `StatusLaundry` Enum                   |
| `prioritas`                | Enum        | Tingkat prioritas laundry berdasarkan `PrioritasLaundry` Enum            |
| `total_biaya`              | Decimal     | Total biaya akhir yang harus dibayarkan pelanggan                        |
| `created_at`, `updated_at` | Timestamp   | Waktu pembuatan dan perubahan data                                       |

### Tabel `transaksi_detail`

Tabel `transaksi_detail` digunakan untuk menyimpan rincian item atau muatan cucian pada setiap transaksi. Data pada tabel ini juga digunakan sebagai variabel input dalam proses Fuzzy Logic.

| Nama Kolom                 | Tipe Data   | Keterangan                                                                  |
| :------------------------- | :---------- | :-------------------------------------------------------------------------- |
| `id`                       | BigInt (PK) | Primary key                                                                 |
| `transaksi_id`             | BigInt (FK) | Foreign key yang merujuk ke tabel `transaksi`                               |
| `layanan_id`               | BigInt (FK) | Foreign key yang merujuk ke tabel `layanan`                                 |
| `noda_pakaian_id`          | BigInt (FK) | Foreign key yang merujuk ke tabel `noda_pakaian`, bersifat opsional         |
| `berat`                    | Float       | Berat total pakaian                                                         |
| `jumlah`                   | Integer     | Jumlah pakaian dalam satuan keping atau pcs                                 |
| `tingkat_kekotoran`        | Integer     | Tingkat kekotoran pakaian yang digunakan sebagai variabel input Fuzzy Logic |
| `created_at`, `updated_at` | Timestamp   | Waktu pembuatan dan perubahan data                                          |

### Tabel `pembayaran`

Tabel `pembayaran` digunakan untuk mencatat informasi pembayaran pelanggan serta menyimpan data yang berkaitan dengan integrasi Payment Gateway Midtrans.

| Nama Kolom                 | Tipe Data     | Keterangan                                                   |
| :------------------------- | :------------ | :----------------------------------------------------------- |
| `id`                       | BigInt (PK)   | Primary key                                                  |
| `transaksi_id`             | BigInt (FK)   | Foreign key yang merujuk ke tabel `transaksi`                |
| `jumlah_pembayaran`        | Decimal (x,2) | Nominal pembayaran yang harus dibayarkan                     |
| `metode_pembayaran`        | Enum          | Metode pembayaran berdasarkan `MetodePembayaran` Enum        |
| `payment_gateway`          | Varchar       | Nama penyedia layanan pembayaran, bersifat opsional          |
| `status_pembayaran`        | Enum          | Status pembayaran berdasarkan `StatusPembayaran` Enum        |
| `tanggal_pembayaran`       | DateTime      | Waktu pembayaran berhasil dilakukan                          |
| `snap_token`               | Varchar       | Token autentikasi yang digunakan oleh Midtrans               |
| `payment_type`             | Varchar       | Jenis instrumen pembayaran, misalnya QRIS atau bank transfer |
| `bank`                     | Varchar       | Nama bank yang digunakan untuk pembayaran                    |
| `va_number`                | Varchar       | Nomor Virtual Account pembayaran                             |
| `midtrans_order_id`        | Varchar       | ID pesanan yang digunakan untuk sinkronisasi dengan Midtrans |
| `midtrans_transaction_id`  | Varchar       | ID transaksi yang diberikan oleh Midtrans                    |
| `transaction_status`       | Varchar       | Status transaksi berdasarkan respons dari server Midtrans    |
| `expired_at`               | DateTime      | Batas waktu pembayaran                                       |
| `catatan`                  | Text          | Catatan tambahan terkait pembayaran                          |
| `created_at`, `updated_at` | Timestamp     | Waktu pembuatan dan perubahan data                           |

---

## 3. Penjelasan Relasi Antar Tabel (Entity Relationships)

Sistem menggunakan relasi antar tabel untuk menghubungkan data yang saling berkaitan. Relasi tersebut diterapkan menggunakan _Eloquent Relationships_ pada Laravel.

### a. Relasi `users` dengan `pelanggan`

Tabel `users` memiliki relasi **One-to-One (1:1)** dengan tabel `pelanggan`. Satu akun pengguna dapat memiliki satu profil pelanggan. Sebaliknya, setiap data pelanggan dapat terhubung dengan satu akun pengguna melalui `user_id`.

- `users → pelanggan`: **HasOne**
- `pelanggan → users`: **BelongsTo**

### b. Relasi `pelanggan` dengan `transaksi`

Tabel `pelanggan` memiliki relasi **One-to-Many (1:N)** dengan tabel `transaksi`. Satu pelanggan dapat melakukan banyak transaksi, sedangkan satu transaksi hanya dimiliki oleh satu pelanggan.

- `pelanggan → transaksi`: **HasMany**
- `transaksi → pelanggan`: **BelongsTo**

### c. Relasi `pelanggan` dengan `reservation`

Tabel `pelanggan` memiliki relasi **One-to-Many (1:N)** dengan tabel `reservation`. Satu pelanggan dapat membuat beberapa reservasi, sedangkan setiap reservasi hanya dimiliki oleh satu pelanggan.

- `pelanggan → reservation`: **HasMany**
- `reservation → pelanggan`: **BelongsTo**

### d. Relasi `transaksi` dengan `transaksi_detail`

Tabel `transaksi` memiliki relasi **One-to-Many (1:N)** dengan tabel `transaksi_detail`. Satu transaksi dapat memiliki satu atau lebih detail cucian, sedangkan setiap detail hanya berkaitan dengan satu transaksi.

- `transaksi → transaksi_detail`: **HasMany** (atau **HasOne**)
- `transaksi_detail → transaksi`: **BelongsTo**

### e. Relasi `transaksi` dengan `pembayaran`

Tabel `transaksi` memiliki relasi dengan tabel `pembayaran` untuk mencatat pembayaran yang berkaitan dengan transaksi. Apabila dalam sistem satu transaksi hanya diperbolehkan memiliki satu data pembayaran, relasinya adalah **One-to-One (1:1)**.

- `transaksi → pembayaran`: **HasOne**
- `pembayaran → transaksi`: **BelongsTo**

### f. Relasi `transaksi` dengan `reservation`

Apabila satu reservasi hanya dapat diproses menjadi satu transaksi dan satu transaksi hanya berasal dari satu reservasi, maka hubungan antara `transaksi` dan `reservation` menggunakan relasi **One-to-One (1:1)**.

- `transaksi → reservation`: **HasOne**
- `reservation → transaksi`: **BelongsTo**

### g. Relasi `layanan` dengan `transaksi_detail`

Tabel `layanan` memiliki relasi **One-to-Many (1:N)** dengan tabel `transaksi_detail`. Satu layanan dapat digunakan pada banyak detail transaksi, sedangkan setiap detail transaksi mengacu pada satu layanan.

- `layanan → transaksi_detail`: **HasMany**
- `transaksi_detail → layanan`: **BelongsTo**

### h. Relasi `layanan` dengan `reservation`

Tabel `layanan` memiliki relasi **One-to-Many (1:N)** dengan tabel `reservation`. Satu layanan dapat dipilih oleh banyak reservasi.

- `layanan → reservation`: **HasMany**
- `reservation → layanan`: **BelongsTo**

### i. Relasi `noda_pakaian` dengan `transaksi_detail`

Tabel `noda_pakaian` memiliki relasi **One-to-Many (1:N)** dengan tabel `transaksi_detail`. Satu jenis noda dapat digunakan pada banyak detail transaksi, sedangkan setiap detail transaksi dapat memiliki satu jenis noda atau tidak memiliki noda.

- `noda_pakaian → transaksi_detail`: **HasMany**
- `transaksi_detail → noda_pakaian`: **BelongsTo**
