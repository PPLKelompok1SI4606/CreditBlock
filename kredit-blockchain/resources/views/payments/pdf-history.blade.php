<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2A9DF4;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #2A9DF4;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .user-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .summary-item {
            padding: 5px;
        }
        .summary-label {
            font-weight: bold;
            color: #2A9DF4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .status-lunas {
            color: #059669;
            font-weight: bold;
        }
        .status-belum {
            color: #D97706;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Riwayat Pembayaran</h1>
        <p>Tanggal Cetak: {{ $summary['export_date'] }}</p>
    </div>

    <div class="user-info">
        <h2>Informasi Pengguna</h2>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <div class="summary">
        <h2>Ringkasan Pembayaran</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-label">Total Pembayaran:</span>
                <br>
                Rp {{ number_format($summary['total_paid'], 0, ',', '.') }}
            </div>
            <div class="summary-item">
                <span class="summary-label">Jumlah Cicilan:</span>
                <br>
                {{ $summary['total_installments'] }} kali
            </div>
            <div class="summary-item">
                <span class="summary-label">Pembayaran Terakhir:</span>
                <br>
                {{ $summary['last_payment_date'] }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Pembayaran Cicilan pada Bulan (Cicilan ke-)</th>
                <th>Nominal</th>
                <th>Sisa Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cumulativePaid = 0;
                $currentLoanId = null;
            @endphp
            @forelse ($payments as $payment)
                @php
                    $loan = $payment->loan;

                    if ($currentLoanId !== $loan->id) {
                        $cumulativePaid = 0;
                        $currentLoanId = $loan->id;
                    }

                    $startMonth = $loan->start_month;
                    $startYear = $loan->start_year;
                    $currentMonth = ($startMonth + $payment->installment_month - 2) % 12 + 1;
                    $currentYear = $startYear + intdiv($startMonth + $payment->installment_month - 2, 12);
                    $monthName = \Carbon\Carbon::create()->month($currentMonth)->format('F');

                    $cumulativePaid += $payment->amount;
                    $remainingAmount = $loan->total_payment - $cumulativePaid;
                    $status = $remainingAmount <= 0 ? 'LUNAS' : 'Belum Lunas';
                @endphp
                <tr>
                    <td>{{ $monthName }} {{ $currentYear }} - Cicilan ke-{{ $payment->installment_month }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($remainingAmount, 0, ',', '.') }}</td>
                    <td class="{{ $status === 'LUNAS' ? 'status-lunas' : 'status-belum' }}">{{ $status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada pembayaran yang belum lunas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem CreditBlock</p>
        <p>© {{ date('Y') }} CreditBlock. All rights reserved.</p>
    </div>
</body>
</html> 