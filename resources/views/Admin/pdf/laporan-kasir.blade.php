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
        <h2>Laporan Kasir</h2>
    </div>

    <div class="info">
        <table>
            @if ($cashier_name)
                <tr>
                    <td><strong>Nama Kasir:</strong></td>
                    <td>{{ $cashier_name }}</td>
                </tr>
            @endif
            <tr>
                <td><strong>Total Jam Kerja:</strong></td>
                <td>{{ number_format($summary['total_work_hours'], 0, ',', '.') }} Jam</td>
            </tr>
            <tr>
                <td><strong>Total Transaksi:</strong></td>
                <td>{{ number_format($summary['total_transactions'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Total Pendapatan:</strong></td>
                <td>Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</td>
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
                <th>Nama Kasir</th>
                <th>Tanggal</th>
                <th>Shift Mulai</th>
                <th>Shift Selesai</th>
                <th>Jam Kerja</th>
                <th>Total Transaksi</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->cashier->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->work_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->shift_start)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->shift_end)->format('H:i') }}</td>
                    <td>{{ number_format($report->total_work_hours, 0, ',', '.') }} Jam</td>
                    <td>{{ number_format($report->total_transactions, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($report->total_revenue, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data laporan yang ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
