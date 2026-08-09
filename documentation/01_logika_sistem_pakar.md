# Logika Sistem Pakar (Fuzzy Logic) pada Sipakar Laundry

Sistem Informasi Manajemen Laundry (Sipakar Laundry) mengimplementasikan sistem pakar berbasis **Fuzzy Logic** untuk mengotomatisasi pengambilan keputusan operasional.

Secara arsitektur, sistem Fuzzy Logic pada aplikasi ini terbagi menjadi **dua mesin evaluasi (Evaluator Engine)** yang berjalan secara independen, di mana secara total sistem menyerap 5 variabel data mentah (_raw input_) dari setiap transaksi pelanggan.

Berikut adalah rincian masing-masing mesin evaluasi:

---

## 1. Mesin Pertama: `DurationEvaluator` (Penentu Estimasi Waktu)

Mesin ini bertugas untuk menghitung dan menentukan estimasi durasi (waktu selesai) dari sebuah pesanan laundry.

Pada tahap awal, mesin menerima 4 parameter data mentah dari transaksi:

- `berat` (Berat pakaian pelanggan)
- `jumlah` (Jumlah satuan/pcs pakaian)
- `tingkatKekotoran` (Level kotor pakaian)
- `jumlahAntrean` (Jumlah pesanan lain yang sedang menunggu diproses)

### Proses Fuzzifikasi (Fuzzification)

Di dalam tahap pemrosesan Fuzzy, keempat data mentah di atas diekstraksi dan disederhanakan menjadi **3 variabel input Fuzzy**:

1.  **Beban (Beban Cucian)**
    Merupakan gabungan/konversi dari variabel `berat` dan `jumlah`.
    _Logika:_ Jika nilai berat lebih dari 0, maka mesin akan menggunakan nilai `berat` (kg). Namun jika tidak, mesin akan menggunakan nilai `jumlah` yang dikalikan dengan bobot 0.2 (asumsi 1 pcs pakaian = 0.2 kg).
2.  **Antrean**
    Variabel ini diambil langsung dari nilai `jumlahAntrean` di sistem.
3.  **Kekotoran**
    Variabel ini dipetakan langsung dari nilai `tingkatKekotoran` pakaian yang diinput oleh admin.

**Output:** Estimasi waktu penyelesaian laundry.

---

## 2. Mesin Kedua: `PriorityEvaluator` (Penentu Prioritas Mesin)

Mesin ini bertugas untuk menentukan urutan prioritas pengerjaan cucian (mana pakaian yang harus masuk mesin cuci terlebih dahulu).

Mesin ini menerima 2 parameter data mentah:

- `tingkatKekotoran` (Level kotor pakaian)
- `lamaMenunggu` (Waktu dari pesanan masuk hingga saat ini/waktu evaluasi)

### Proses Fuzzifikasi (Fuzzification)

Proses pada mesin penentu prioritas ini lebih _straightforward_, di mana ia memproses persis **2 variabel input Fuzzy**:

1.  **Kekotoran**
    Fuzzifikasi langsung dari variabel `tingkatKekotoran`.
2.  **Waktu Tunggu**
    Fuzzifikasi langsung dari variabel `lamaMenunggu`. Semakin lama pakaian mengendap tanpa diproses, nilainya akan semakin mempengaruhi prioritas.

**Output:** Tingkat prioritas pengerjaan (misal: Rendah, Normal, Tinggi, Kritis).

---

## 📌 Ringkasan Implementasi

Secara matematis murni, arsitektur Fuzzy Logic pada Sipakar Laundry terdiri dari:

- **Mesin Durasi:** Memiliki 3 Input Fuzzy (_Beban, Antrean, Kekotoran_).
- **Mesin Prioritas:** Memiliki 2 Input Fuzzy (_Kekotoran, Waktu Tunggu_).

Kedua mesin tersebut didesain sangat efisien karena **saling berbagi penggunaan data variabel** `tingkatKekotoran` dari satu objek pesanan yang sama, tanpa perlu melakukan pemanggilan ulang ke basis data. Pemisahan _concern_ (tugas) ini membuat kode menjadi sangat _scalable_ (mudah dikembangkan di masa depan).
