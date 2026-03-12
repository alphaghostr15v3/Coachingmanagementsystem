<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Salary Slip - {{ $salarySlip->month }} {{ $salarySlip->year }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            text-transform: uppercase;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .title {
            text-align: center;
            margin-bottom: 30px;
        }
        .title h2 {
            display: inline-block;
            border: 1px solid #333;
            padding: 5px 20px;
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 18px;
            margin: 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table td {
            vertical-align: top;
            width: 50%;
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-table th {
            text-align: left;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            padding: 2px 0;
        }
        .detail-table td {
            padding: 2px 0;
        }
        .salary-table {
            width: 100%;
            border: 1px solid #ccc;
            margin-bottom: 0;
        }
        .salary-table th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .salary-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }
        .salary-table .text-right {
            text-align: right;
        }
        .totals-table {
            width: 100%;
            border: 1px solid #ccc;
            border-top: none;
            background-color: #f8f9fa;
            margin-bottom: 30px;
        }
        .totals-table td {
            padding: 10px;
            font-weight: bold;
            width: 50%;
        }
        .net-salary-box {
            background-color: #eef2ff;
            border: 1px solid #6366f1;
            padding: 20px;
            text-align: center;
            margin-bottom: 40px;
        }
        .net-salary-box p {
            margin: 0 0 5px 0;
            text-transform: uppercase;
            color: #6366f1;
            font-weight: bold;
            font-size: 12px;
        }
        .net-salary-box h2 {
            margin: 0;
            color: #6366f1;
            font-size: 32px;
        }
        .footer {
            width: 100%;
            margin-top: 50px;
        }
        .footer td {
            width: 50%;
            vertical-align: bottom;
        }
        .signature {
            border-top: 1px solid #000;
            display: inline-block;
            padding-top: 5px;
            width: 200px;
            text-align: center;
        }
        .system-gen {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $currentCoaching->coaching_name ?? 'Coaching Center' }}</h1>
        <p>{{ $currentCoaching->address ?? 'Address Not Set' }}</p>
        <p>Phone: {{ $currentCoaching->phone ?? 'N/A' }} | Email: {{ $currentCoaching->email ?? 'N/A' }}</p>
    </div>

    <div class="title">
        <h2>Payslip</h2>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <table class="detail-table">
                    <tr><th>Employee Name</th></tr>
                    <tr><td style="font-weight: bold;">{{ $salarySlip->teacher->name }}</td></tr>
                    <tr><th>Email</th></tr>
                    <tr><td>{{ $salarySlip->teacher->email }}</td></tr>
                    <tr><th>Designation</th></tr>
                    <tr><td>Teacher / Faculty</td></tr>
                    <tr><th>Employee ID</th></tr>
                    <tr><td>#{{ str_pad($salarySlip->teacher->id, 4, '0', STR_PAD_LEFT) }}</td></tr>
                </table>
            </td>
            <td style="padding-left: 20px; border-left: 1px solid #eee;">
                <table class="detail-table">
                    <tr><th>Payslip No.</th></tr>
                    <tr><td style="font-weight: bold;">#{{ str_pad($salarySlip->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                    <tr><th>Earnings Period</th></tr>
                    <tr><td style="font-weight: bold; color: #6366f1;">{{ $salarySlip->month }} {{ $salarySlip->year }}</td></tr>
                    <tr><th>Payment Date</th></tr>
                    <tr><td>{{ $salarySlip->payment_date->format('d F, Y') }}</td></tr>
                    <tr><th>Status</th></tr>
                    <tr><td style="font-weight: bold;">{{ strtoupper($salarySlip->payment_status) }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="50%" valign="top" style="padding-right: 0;">
                <table class="salary-table">
                    <tr>
                        <th>Earnings</th>
                        <th class="text-right">Amount (₹)</th>
                    </tr>
                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-right" style="font-weight: bold;">{{ number_format($salarySlip->basic_salary, 2) }}</td>
                    </tr>
                    @if($salarySlip->total_days > 0 && $salarySlip->per_day_pay > 0)
                    <tr>
                        <td style="font-size: 11px; color: #666; padding-top: 0; padding-left: 20px;">
                            Calculation: {{ $salarySlip->total_days }} days &times; ₹{{ number_format($salarySlip->per_day_pay, 2) }} / day
                        </td>
                        <td style="padding-top: 0;"></td>
                    </tr>
                    @endif
                    @php $totalEarnings = 0; @endphp
                    @if(is_array($salarySlip->earnings))
                        @foreach($salarySlip->earnings as $earning)
                            <tr>
                                <td>{{ $earning['name'] }}</td>
                                <td class="text-right">{{ number_format($earning['amount'], 2) }}</td>
                            </tr>
                            @php $totalEarnings += (float)$earning['amount']; @endphp
                        @endforeach
                    @endif
                </table>
            </td>
            <td width="50%" valign="top" style="padding-left: 0;">
                <table class="salary-table" style="border-left: none;">
                    <tr>
                        <th>Deductions</th>
                        <th class="text-right">Amount (₹)</th>
                    </tr>
                    @php $totalDeductions = 0; @endphp
                    @if(is_array($salarySlip->deductions))
                        @foreach($salarySlip->deductions as $deduction)
                            <tr>
                                <td>{{ $deduction['name'] }}</td>
                                <td class="text-right">{{ number_format($deduction['amount'], 2) }}</td>
                            </tr>
                            @php $totalDeductions += (float)$deduction['amount']; @endphp
                        @endforeach
                    @endif
                    @if(empty($salarySlip->deductions))
                        <tr>
                            <td style="color: #999; font-style: italic;">No deductions</td>
                            <td class="text-right">0.00</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <table class="totals-table">
        <tr>
            <td style="border-right: 1px solid #ccc;">
                <table width="100%">
                    <tr>
                        <td>Total Earnings:</td>
                        <td align="right">₹{{ number_format($salarySlip->basic_salary + $totalEarnings, 2) }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="100%">
                    <tr>
                        <td>Total Deductions:</td>
                        <td align="right">₹{{ number_format($totalDeductions, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="net-salary-box">
        <p>Net Salary Transfer</p>
        <h2>₹{{ number_format($salarySlip->net_salary, 2) }}</h2>
    </div>

    <table class="footer">
        <tr>
            <td>
                @if($salarySlip->remarks)
                    <div style="font-weight: bold; color: #666; font-size: 12px; text-transform: uppercase;">Remarks:</div>
                    <div style="font-style: italic; border-left: 3px solid #6366f1; padding-left: 10px; margin-top: 5px;">
                        {{ $salarySlip->remarks }}
                    </div>
                @endif
            </td>
            <td align="right">
                <div class="signature">
                    <div style="font-weight: bold;">Authorized Signatory</div>
                    <div style="font-size: 12px; color: #666;">{{ $currentCoaching->coaching_name ?? 'Management' }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="system-gen">
        This is a system generated payslip.
    </div>
</body>
</html>
