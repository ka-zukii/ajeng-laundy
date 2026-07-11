<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $nama_gejala
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rule> $rules
 * @property-read int|null $rules_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereNamaGejala($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gejala whereUpdatedAt($value)
 */
	class Gejala extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_layanan
 * @property string $tipe_layanan
 * @property numeric $biaya_layanan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiDetail> $transaksiDetail
 * @property-read int|null $transaksi_detail_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereBiayaLayanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereNamaLayanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereTipeLayanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Layanan whereUpdatedAt($value)
 */
	class Layanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $transaksi_id
 * @property string|null $metode_pembayaran
 * @property string $tanggal_pembayaran
 * @property numeric $jumlah_pembayaran
 * @property string|null $status_pembayaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Transaksi $transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereJumlahPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereMetodePembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereStatusPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTransaksiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereUpdatedAt($value)
 */
	class Pembayaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_penyakit
 * @property string $solusi
 * @property numeric $biaya_tambahan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rule> $rule
 * @property-read int|null $rule_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiDetail> $transaksiDetail
 * @property-read int|null $transaksi_detail_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda whereBiayaTambahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda whereNamaPenyakit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda whereSolusi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenyakitNoda whereUpdatedAt($value)
 */
	class PenyakitNoda extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $penyakit_noda_id
 * @property int $gejala_id
 * @property numeric $cf_pakar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Gejala $gejala
 * @property-read \App\Models\PenyakitNoda $penyakitNoda
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule whereCfPakar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule whereGejalaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule wherePenyakitNodaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rule whereUpdatedAt($value)
 */
	class Rule extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $users_id
 * @property string $kode_transaksi
 * @property string $tanggal_masuk
 * @property string $tanggal_selesai
 * @property string|null $status_laundry
 * @property numeric $total_biaya
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pembayaran|null $pembayaran
 * @property-read \App\Models\TransaksiDetail|null $transaksiDetail
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereKodeTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereStatusLaundry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTanggalMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereTotalBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaksi whereUsersId($value)
 */
	class Transaksi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $transaksi_id
 * @property int|null $layanan_id
 * @property int|null $penyakit_noda_id
 * @property int|null $berat
 * @property int|null $jumlah
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PenyakitNoda|null $penyakitNoda
 * @property-read \App\Models\Transaksi $transaksi
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereBerat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereLayananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail wherePenyakitNodaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereTransaksiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiDetail whereUpdatedAt($value)
 */
	class TransaksiDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string $nomor_telepon
 * @property string|null $alamat
 * @property string|null $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaksi> $transaksi
 * @property-read int|null $transaksi_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNomorTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\HasName {}
}

