<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3E81AB;
            color: white;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            border: none;
        }

        .info td {
            border: none;
            padding: 4px;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi</h2>

    <div class="info">
        <table>
            <tr>
                <td><strong>Total Transaksi:</strong></td>
                <td>{{ number_format($totalTransactions, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Pendapatan:</strong></td>
                <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Waktu Download:</strong></td>
                <td>{{ now()->isoFormat('dddd, D MMMM Y HH:mm') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kasir</th>
                <th>Nama Device</th>
                <th>Jenis Paket</th>
                <th>Waktu Paket</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Waktu Berhenti</th>
                <th>Harga Total(Rp)</th>
                <th>Harga (Rp)</th>
                <th>Diskon(Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->user->name ?? '-' }}</td>
                    <td>{{ $transaction->device->name ?? '-' }}</td>
                    <td>{{ $transaction->package_name }}</td>
                    <td>{{ $transaction->package_time }} Menit</td>
                    <td>{{ $transaction->start_time ? \Carbon\Carbon::parse($transaction->start_time)->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    <td>{{ $transaction->end_time ? \Carbon\Carbon::parse($transaction->end_time)->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    <td>{{ $transaction->updated_at ? \Carbon\Carbon::parse($transaction->updated_at)->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    <td>{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td>{{ $transaction->original_price > 0 ? number_format($transaction->original_price, 0, ',', '.') : number_format($transaction->total_price, 0, ',', '.') }}
                    </td>
                    <td>{{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
