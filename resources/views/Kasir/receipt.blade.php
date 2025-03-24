<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 10px;
            text-align: center;
        }

        .receipt {
            max-width: 280px;
            margin: auto;
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
        }

        h2 {
            margin: 5px 0;
            font-size: 14px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
        }

        .logo {
            max-width: 60px;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 11px;
            font-weight: bold;
            line-height: 1.2;
            margin: 2px 0;
        }

        .transaction-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Membuat semua elemen ke tengah */
            width: 100%;
        }

        .transaction-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            /* Atur lebar agar tidak terlalu melebar */
            max-width: 400px;
            /* Batas maksimum agar tetap proporsional */
            margin: 2px 0;
        }

        .transaction-row p {
            margin: 0;
            padding: 2px 0;
            width: 80%;
            /* Agar teks di kiri dan kanan tetap sejajar */
        }

        .transaction-row p:first-child {
            text-align: left;
        }

        .transaction-row p:last-child {
            text-align: right;
        }

        .price-breakdown {
            border-top: 1px dashed #000;
            margin-top: 5px;
            padding-top: 5px;
            font-size: 11px;
        }

        .discount {
            color: #FB2C36;
        }

        .final-price {
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body onload="window.print(); setTimeout(() => window.close(), 500);">
    <div class="receipt">
        <!-- Logo & Informasi Perusahaan -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan" class="logo">
        <p class="company-info">Nama Perusahaan</p>
        <p class="company-info">Jl. Contoh No. 123, Kota, Indonesia</p>
        <p class="company-info">Telp: 0812-3456-7890</p>
        <div class="line"></div>

        <h2>Struk Pembayaran</h2>
        <p>{{ $transaction['date'] }}</p>
        <div class="line"></div>
        <div class="transaction-info">
            <div class="transaction-row">
                <p><strong>Kasir:</strong></p>
                <p>{{ $transaction['cashier_name'] }}</p>
            </div>
            <div class="transaction-row">
                <p><strong>Device:</strong></p>
                <p>{{ $transaction['device_name'] }}</p>
            </div>
            <div class="transaction-row">
                <p><strong>Paket:</strong></p>
                <p>{{ $transaction['package_name'] }}</p>
            </div>
            <div class="transaction-row">
                <p><strong>Durasi:</strong></p>
                <p>{{ $transaction['package_time'] }} Menit</p>
            </div>
            <div class="transaction-row">
                <p><strong>Mulai:</strong></p>
                <p>{{ $transaction['start_time'] }}</p>
            </div>
            <div class="transaction-row">
                <p><strong>Selesai:</strong></p>
                <p>{{ $transaction['end_time'] }}</p>
            </div>
        </div>
        <div class="line"></div>

        @if ($transaction['package_name'] === 'Open Billing' && isset($transaction['original_price']))
            <div class="transaction-info">
                <div class="transaction-row">
                    <p><strong>Harga Awal:</strong></p>
                    <p>Rp {{ number_format($transaction['original_price'], 0, ',', '.') }}</p>
                </div>
                <div class="transaction-row">
                    <p><strong>Diskon:</strong></p>
                    <p>-Rp {{ number_format($transaction['discount_amount'], 0, ',', '.') }}</p>
                </div>
                <div class="transaction-row">
                    <p><strong>Harga Akhir:</strong></p>
                    <p>Rp {{ number_format($transaction['total_price'], 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="line"></div>
        @endif


        <p class="total">Total: Rp {{ number_format($transaction['total_price'], 0, ',', '.') }}</p>
        <div class="line"></div>
        <p>Terima Kasih!</p>
    </div>
</body>

</html>
