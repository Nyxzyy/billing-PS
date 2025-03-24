<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
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

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Device</h2>
    </div>

    <div class="info">
        <table>
            @if ($device_name)
                <tr>
                    <td><strong>Nama Device:</strong></td>
                    <td>{{ $device_name }}</td>
                </tr>
            @endif
            <tr>
                <td><strong>Total Kendala:</strong></td>
                <td>{{ number_format($summary['total_kendala'], 0, ',', '.') }} Kali</td>
            </tr>
            <tr>
                <td><strong>Total Waktu Pakai:</strong></td>
                <td>{{ $summary['total_waktu_pakai'] }}</td>
            </tr>
            <tr>
                <td><strong>Total Booking:</strong></td>
                <td>{{ number_format($summary['total_booking'], 0, ',', '.') }} Transaksi</td>
            </tr>
            <tr>
                <td><strong>Total Pendapatan:</strong></td>
                <td>Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</td>
            </tr>
            @if ($start_date && $end_date)
                <tr>
                    <td><strong>Periode:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</td>
                </tr>
            @endif
            <tr>
                <td><strong>Waktu Download:</strong></td>
                <td>{{ $tanggalDownload }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Device</th>
                <th>Nama Pengguna</th>
                <th>Paket</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Total Waktu</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->device->name ?? '-' }}</td>
                    <td>{{ $transaction->user->name ?? '-' }}</td>
                    <td>{{ $transaction->package_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->start_time)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->end_time)->format('H:i') }}</td>
                    <td>{{ $transaction->package_time }} Menit</td>
                    <td class="text-right">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data transaksi yang ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
