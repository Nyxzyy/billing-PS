<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 10px; text-align: center; }
        .receipt { max-width: 280px; margin: auto; border: 1px solid #000; padding: 8px; font-size: 12px; }
        h2 { margin: 5px 0; font-size: 14px; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        .total { font-size: 14px; font-weight: bold; }
        .logo { max-width: 60px; margin-bottom: 5px; }
        .company-info { font-size: 11px; font-weight: bold; line-height: 1.2; margin: 2px 0; }
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
        <p><strong>Kasir:</strong> {{ $transaction['cashier_name'] }}</p>
        <p><strong>Device:</strong> {{ $transaction['device_name'] }}</p>
        <p><strong>Paket:</strong> {{ $transaction['package_name'] }}</p>
        <p><strong>Durasi:</strong> {{ $transaction['package_time'] }} Menit</p>
        <p><strong>Mulai:</strong> {{ $transaction['start_time'] }}</p>
        <p><strong>Selesai:</strong> {{ $transaction['end_time'] }}</p>
        <div class="line"></div>
        <p class="total">Total: Rp {{ number_format($transaction['total_price'], 0, ',', '.') }}</p>
        <div class="line"></div>
        <p>Terima Kasih!</p>
    </div>
</body>
</html>
