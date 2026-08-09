# Arsitektur Sistem & Pola Desain Kode (Design Pattern)

Sistem Informasi **Sipakar Laundry** dibangun menggunakan _framework_ Laravel 11. Namun, aplikasi ini tidak sekadar menggunakan standar MVC (_Model-View-Controller_) biasa. Untuk memastikan sistem mudah dipelihara (_maintainable_), mudah diuji (_testable_), dan kebal terhadap anomali data, kami menerapkan standar arsitektur industri perangkat lunak modern.

Berikut adalah rincian pola desain dan arsitektur kode yang kami terapkan:

---

## 1. Implementasi _Service Pattern_ (Separation of Concerns)

Salah satu masalah utama dalam pengembangan Laravel adalah _Fat Controller_ (Controller yang terlalu gemuk karena menampung seluruh logika bisnis). Kami memecahkan masalah ini dengan memindahkan seluruh _Business Logic_ (logika bisnis inti) ke dalam direktori `app/Services/`.

Dengan pola ini, Controller bertugas murni hanya untuk menerima _Request_ (Input HTTP) dan mengembalikan _Response_ (View/JSON).

### Bedah Kasus: Folder `app/Services/Transaksi/`

Sebagai contoh, proses pembuatan transaksi baru sangatlah kompleks. Sistem harus menghitung harga, memproses Fuzzy Logic, menyimpan data Transaksi, menyimpan Detail Transaksi, hingga membuat tagihan Pembayaran.

Tugas berat ini dipecah menggunakan prinsip **Single Responsibility Principle (SRP)** ke dalam 3 kelas _Service_ terpisah:

#### A. `TransactionCalculator.php` (Penghitung Biaya)

Service ini bertugas murni untuk menghitung uang. Kode ini menggunakan fitur modern **PHP 8 Match Expression** untuk menentukan cara hitung berdasarkan tipe layanan (Kiloan atau Satuan), serta otomatis menambahkan biaya ekstra jika ada noda (_null-safe operator_ `?->`).

```php
$subtotal = match ($layanan->jenis_perhitungan) {
    JenisPerhitungan::KILOAN => $layanan->biaya_layanan * ($data['berat'] ?? 0),
    JenisPerhitungan::SATUAN => $layanan->biaya_layanan * ($data['jumlah'] ?? 0),
};
return $subtotal + ($noda?->biaya_tambahan ?? 0);
```

#### B. `TransactionCodeService.php` (Pembuat Kode Unik)

Bertugas khusus menghasilkan kode resi transaksi dengan format `AJL-YYYYMMDD-XXXXXX`. Service ini menggunakan perulangan `do-while` untuk mengecek database secara real-time guna memastikan tidak akan pernah ada kode transaksi yang duplikat (collision-free).

#### C. `TransactionService.php` (Service Transaksi Utama)

Ini adalah otak utama yang menggabungkan semua service di atas menggunakan Dependency Injection.

```php
public function __construct(
    protected TransactionCalculator $calculator,
    protected FuzzyLaundryService $fuzzyService,
    protected PaymentService $paymentService,
) {}
```

## 2. Keamanan Data dengan Database Transactions

Karena proses pembuatan pesanan laundry melibatkan penyimpanan data ke tiga tabel berbeda secara berurutan (`transaksi`, `transaksi_detail`, dan `pembayaran`), ada risiko sistem mati mendadak di tengah proses (misal: Transaksi tersimpan, tapi tagihan gagal dibuat).

Untuk mencegah anomali atau data yang menggantung (orphan data), `TransactionService` membungkus proses eksekusinya dengan `DB::transaction()`.

```php
public function create(array $data): Transaksi
{
    return DB::transaction(function () use ($data) {
        // 1. Hitung total & proses Fuzzy
        // 2. Insert tabel transaksi
        // 3. Insert tabel transaksi_detail
        // 4. Insert tabel pembayaran
    });
}
```

Keuntungan: Jika salah satu baris fungsi (misal tahap ke-4) gagal dijalankan karena error, maka tahap 1 hingga 3 yang sudah masuk ke memori database akan otomatis dibatalkan (Rollback). Database akan selalu tetap bersih dan konsisten.

## 3. Penggunaan PHP 8 Enums (Type Safety)

Sistem ini sangat menghindari penggunaan Hardcoded String (mengetik teks manual seperti `"kiloan"` atau `"pending"`) untuk mendefinisikan status atau tipe. Kami menggunakan Enums (`app/Enums/`).

Contoh Enum yang digunakan:

- `JenisPerhitungan::KILOAN`
- `StatusLaundry::PENDING`

Keuntungan:
Mencegah terjadinya human error atau typo (salah ketik) saat coding. Jika developer salah mengetik nama status, aplikasi akan langsung memunculkan error sebelum dieksekusi, sehingga keamanan data terjamin.
