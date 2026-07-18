<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Pembayaran</title>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>

<body>

    <h2>Pembayaran Laundry</h2>
    <hr>

    <p>
        <b>Kode Transaksi</b><br>
        {{ $transaksi->kode_transaksi }}
    </p>

    <p>
        <b>Pelanggan</b><br>
        {{ $transaksi->pelanggan->nama }}
    </p>

    <p>
        <b>Total</b><br>
        Rp {{ number_format($pembayaran->jumlah_pembayaran) }}
    </p>

    <button id="pay-button">
        Bayar Sekarang
    </button>

    <script>
        document
            .getElementById('pay-button')
            .onclick = function() {
                snap.pay(
                    "{{ $pembayaran->snap_token }}", {
                        onSuccess(result) {
                            location.reload();
                        },

                        onPending(result) {
                            alert("Menunggu pembayaran");
                        },

                        onError(result) {
                            alert("Pembayaran gagal");
                        },


                        onClose() {
                            alert("Popup ditutup");
                        }
                    }
                );
            };
    </script>

</body>

</html>
