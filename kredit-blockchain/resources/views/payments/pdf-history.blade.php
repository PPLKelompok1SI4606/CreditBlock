<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Riwayat Pembayaran</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 30px;
            color: #1f2937;
            background-color: #f8fafc;
        }
        .container {
            background-color: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3b82f6;
            position: relative;
        }
        .header h1 {
            color: #1f2937;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: -0.025em;
        }
        .header p {
            color: #6b7280;
            margin-top: 8px;
            font-size: 16px;
        }
        .user-info {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f0f9ff;
            border-radius: 12px;
            border: 1px solid #e0f2fe;
        }
        .user-info p {
            margin: 8px 0;
            font-size: 14px;
            color: #374151;
        }
        .user-info strong {
            color: #1f2937;
            font-weight: 600;
        }
        .summary {
            margin-bottom: 40px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .summary h2 {
            color: #1f2937;
            margin: 0 0 20px 0;
            font-size: 20px;
            font-weight: 600;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .summary-item {
            padding: 15px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }
        .summary-item strong {
            color: #4b5563;
            font-size: 13px;
            display: block;
            margin-bottom: 5px;
        }
        .summary-item span {
            color: #1f2937;
            font-size: 16px;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background-color: #3b82f6;
            color: white;
            padding: 14px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
            color: #374151;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .amount {
            text-align: right;
            font-family: 'DejaVu Sans Mono', monospace;
            font-weight: 600;
        }
        .status {
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status-lunas {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-belum-lunas {
            background-color: #fef3c7;
            color: #92400e;
        }
        .page-number {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Riwayat Pembayaran</h1>
            <p>Dokumen resmi riwayat pembayaran cicilan</p>
        </div>

        <div class="user-info">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>

        <div class="summary">
            <h2>Ringkasan Pembayaran</h2>
            <div class="summary-grid">
                <div class="summary-item">
                    <strong>Total Pembayaran</strong>
                    <span>Rp {{ number_format($summary['total_paid'], 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <strong>Total Cicilan</strong>
                    <span>{{ $summary['total_installments'] }} kali</span>
                </div>
                <div class="summary-item">
                    <strong>Pembayaran Terakhir</strong>
                    <span>{{ $summary['last_payment_date'] }}</span>
                </div>
                <div class="summary-item">
                    <strong>Tanggal Ekspor</strong>
                    <span>{{ $summary['export_date'] }}</span>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Cicilan Ke</th>
                    <th class="amount">Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->payment_date->format('d F Y') }}</td>
                    <td>{{ $payment->installment_month }}</td>
                    <td class="amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>
                        <span class="status {{ $payment->status === 'Lunas' ? 'status-lunas' : 'status-belum-lunas' }}">
                            {{ $payment->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Dokumen ini digenerate secara otomatis pada {{ $summary['export_date'] }}</p>
            <p>© {{ date('Y') }} CreditBlock. All rights reserved.</p>
        </div>
    </div>
    <div class="page-number">Halaman 1</div>
</body>
</html>
