<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; text-align: center; }
        .receipt { max-width: 300px; margin: auto; border: 1px solid #000; padding: 10px; }
        h2 { margin-bottom: 5px; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        .total { font-size: 16px; font-weight: bold; }
    </style>
</head>
<body onload="window.print(); setTimeout(() => window.close(), 500);">
    <div class="receipt">
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
