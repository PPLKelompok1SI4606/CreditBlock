<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman PDF</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <h2>Riwayat Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>Mulai</th>
                <th>Akhir</th>
                <th>Nominal</th>
                <th>Durasi</th>
                <th>Sisa Bulan</th>
                <th>Bunga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loanApplications as $loan)
                <tr>
                    <td>{{ \Carbon\Carbon::create($loan->start_year, $loan->start_month)->translatedFormat('F Y') }}
                    </td>
                    <td>{{ \Carbon\Carbon::create($loan->end_year, $loan->end_month)->translatedFormat('F Y') }}</td>
                    <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                    <td>{{ $loan->duration }} Bulan</td>
                    <td>
                        @php
                            $endDate = \Carbon\Carbon::create($loan->end_year, $loan->end_month, 1);
                            $now = \Carbon\Carbon::now();
                            $remainingMonths = $now->greaterThan($endDate) ? 0 : $now->diffInMonths($endDate);
                        @endphp
                        {{ round($remainingMonths) }} Bulan
                    </td>
                    <td>{{ $loan->interest_rate }}%</td>
                    <td>{{ $loan->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
