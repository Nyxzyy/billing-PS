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

        .status-pending {
            background-color: #FEF9C3;
            color: #854D0E;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 12px;
        }

        .status-proses {
            background-color: #DBEAFE;
            color: #1E40AF;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 12px;
        }

        .status-selesai {
            background-color: #DCFCE7;
            color: #166534;
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Kendala</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Total Kendala:</strong></td>
                <td>{{ number_format($totalKendala, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Status Pending:</strong></td>
                <td>{{ number_format($pendingCount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Status Selesai:</strong></td>
                <td>{{ number_format($selesaiCount, 0, ',', '.') }}</td>
            </tr>
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
                <th>Nama Device</th>
                <th>Kendala</th>
                <th>Jam</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Waktu Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kendalaReports as $index => $report)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->cashier->name ?? '-' }}</td>
                    <td>{{ $report->device->name ?? '-' }}</td>
                    <td>{{ $report->issue }}</td>
                    <td>{{ $report->time }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->date)->format('d/m/Y') }}</td>
                    <td>
                        <span
                            class="
                            @if ($report->status == 'Pending') status-pending
                            @elseif($report->status == 'Proses') status-proses
                            @elseif($report->status == 'Selesai') status-selesai @endif
                        ">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td>
                        @if ($report->status == 'Selesai')
                            {{ \Carbon\Carbon::parse($report->updated_at)->format('d/m/Y H:i:s') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data kendala yang ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
