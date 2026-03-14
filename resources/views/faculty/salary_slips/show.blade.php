@extends('layouts.faculty')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <a href="{{ route('faculty.salary-slips.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Back to Slips
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('faculty.salary-slips.download', $salarySlip->id) }}" class="btn btn-outline-danger shadow-sm rounded-pill px-4">
                <i class="fas fa-file-pdf me-2"></i> Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-print me-2"></i> Print Slip
            </button>
        </div>
    </div>

    <div class="payslip-wrapper">
        <div class="payslip-container shadow-sm">
            <div class="header">
                <h1>{{ $currentCoaching->coaching_name ?? 'Coaching Center' }}</h1>
                <p>{{ $currentCoaching->address ?? 'Address Not Set' }}</p>
                <p>Email: {{ $currentCoaching->email ?? 'N/A' }}</p>
            </div>

            <div class="title">
                <h2>Payslip</h2>
            </div>

            <table class="info-table">
                <tr>
                    <td class="w-50 align-top">
                        <table class="detail-table w-100">
                            <tr><th>Employee Name</th></tr>
                            <tr><td class="fw-bold-dark">{{ $salarySlip->faculty->name ?? 'N/A' }}</td></tr>
                            <tr><th>Email</th></tr>
                            <tr><td>{{ $salarySlip->faculty->email ?? 'N/A' }}</td></tr>
                            <tr><th>Designation</th></tr>
                            <tr><td>Faculty</td></tr>
                            <tr><th>Employee ID</th></tr>
                            <tr><td>#{{ str_pad($salarySlip->faculty->id, 4, '0', STR_PAD_LEFT) }}</td></tr>
                        </table>
                    </td>
                    <td class="w-50 align-top ps-4 border-start-light">
                        <table class="detail-table w-100">
                            <tr><th>Payslip No.</th></tr>
                            <tr><td class="fw-bold-dark">#{{ str_pad($salarySlip->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                            <tr><th>Earnings Period</th></tr>
                            <tr><td class="fw-bold-indigo">{{ $salarySlip->month }} {{ $salarySlip->year }}</td></tr>
                            <tr><th>Payment Date</th></tr>
                            <tr><td>{{ $salarySlip->payment_date ? $salarySlip->payment_date->format('d F, Y') : 'N/A' }}</td></tr>
                            <tr><th>Status</th></tr>
                            <tr><td class="fw-bold-dark text-uppercase">{{ $salarySlip->payment_status }}</td></tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="w-100 mb-0 border-collapse table-fixed">
                <tr>
                    <td class="w-50 align-top p-0 border">
                        <table class="salary-table w-100">
                            <thead>
                                <tr>
                                    <th>Earnings</th>
                                    <th class="text-end px-3">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td class="text-end px-3 fw-bold">{{ number_format($salarySlip->basic_salary, 2) }}</td>
                                </tr>
                                @if($salarySlip->total_days > 0 && $salarySlip->per_day_pay > 0)
                                <tr>
                                    <td colspan="2" class="calculation-text">
                                        Calculation: {{ $salarySlip->total_days }} days &times; ₹{{ number_format($salarySlip->per_day_pay, 2) }} / day
                                    </td>
                                </tr>
                                @endif
                                @php $totalEarnings = 0; @endphp
                                @if(is_array($salarySlip->earnings))
                                    @foreach($salarySlip->earnings as $earning)
                                        <tr>
                                            <td>{{ $earning['name'] }}</td>
                                            <td class="text-end px-3">{{ number_format($earning['amount'], 2) }}</td>
                                        </tr>
                                        @php $totalEarnings += (float)$earning['amount']; @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </td>
                    <td class="w-50 align-top p-0 border-top border-bottom border-end">
                        <table class="salary-table w-100">
                            <thead>
                                <tr>
                                    <th>Deductions</th>
                                    <th class="text-end px-3">Amount (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalDeductions = 0; @endphp
                                @if(is_array($salarySlip->deductions))
                                    @foreach($salarySlip->deductions as $deduction)
                                        <tr>
                                            <td>{{ $deduction['name'] }}</td>
                                            <td class="text-end px-3">{{ number_format($deduction['amount'], 2) }}</td>
                                        </tr>
                                        @php $totalDeductions += (float)$deduction['amount']; @endphp
                                    @endforeach
                                @endif
                                @if(empty($salarySlip->deductions))
                                    <tr>
                                        <td class="text-muted fst-italic">No deductions</td>
                                        <td class="text-end px-3">0.00</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="totals-table w-100">
                <tr>
                    <td class="border-end py-3">
                        <div class="d-flex justify-content-between px-3 fw-bold">
                            <span>Total Earnings:</span>
                            <span>₹{{ number_format($salarySlip->basic_salary + $totalEarnings, 2) }}</span>
                        </div>
                    </td>
                    <td class="py-3">
                        <div class="d-flex justify-content-between px-3 fw-bold">
                            <span>Total Deductions:</span>
                            <span>₹{{ number_format($totalDeductions, 2) }}</span>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="net-salary-box">
                <p>Net Salary Transfer</p>
                <h2>
                    <span id="netSalaryText">₹{{ number_format($salarySlip->net_salary, 2) }}</span>
                </h2>
            </div>

            <div class="footer-section">
                <table class="w-100">
                    <tr>
                        <td class="w-100 align-bottom">
                            @if($salarySlip->remarks)
                                <div class="remarks">
                                    <strong>Remarks:</strong>
                                    <p>{{ $salarySlip->remarks }}</p>
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="system-gen">
                This is a system generated payslip and does not require a physical signature.
            </div>
        </div>
    </div>
</div>

<style>
    .payslip-wrapper {
        display: flex;
        justify-content: center;
        background-color: #f0f2f5;
        padding: 20px 0;
    }
    .payslip-container {
        width: 100%;
        max-width: 800px;
        background: white;
        padding: 40px;
        font-family: 'DejaVu Sans', sans-serif;
        color: #333;
        line-height: 1.5;
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
        font-weight: 800;
    }
    .header p {
        margin: 5px 0;
        color: #666;
        font-size: 14px;
    }
    .title {
        text-align: center;
        margin-bottom: 30px;
    }
    .title h2 {
        display: inline-block;
        border: 1px solid #333;
        padding: 5px 30px;
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }
    .info-table {
        width: 100%;
        margin-bottom: 30px;
    }
    .detail-table th {
        text-align: left;
        color: #888;
        font-size: 11px;
        text-transform: uppercase;
        padding: 2px 0;
    }
    .detail-table td {
        padding: 1px 0 8px 0;
        font-size: 14px;
    }
    .fw-bold-dark { font-weight: 700; color: #1a1c1e; }
    .fw-bold-indigo { font-weight: 700; color: #6366f1; }
    .border-start-light { border-left: 1px solid #eee; }

    .salary-table thead th {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ccc;
        padding: 10px;
        text-align: left;
        font-size: 13px;
        text-transform: uppercase;
    }
    .salary-table tbody td {
        padding: 8px 10px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }
    .calculation-text {
        font-size: 11px !important;
        color: #888;
        padding: 2px 10px 8px 20px !important;
        border-bottom: 1px solid #eee !important;
    }
    
    .totals-table {
        border: 1px solid #ccc;
        border-top: none;
        background-color: #f8f9fa;
        margin-bottom: 30px;
    }

    .net-salary-box {
        background-color: #eef2ff;
        border: 1px solid #6366f1;
        padding: 25px;
        text-align: center;
        margin-bottom: 40px;
        border-radius: 8px;
    }
    .net-salary-box p {
        margin: 0 0 5px 0;
        text-transform: uppercase;
        color: #6366f1;
        font-weight: 800;
        font-size: 12px;
        letter-spacing: 1px;
    }
    .net-salary-box h2 {
        margin: 0;
        color: #6366f1;
        font-size: 36px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .net-salary-icon {
        height: 35px;
        width: auto;
        vertical-align: middle;
        margin-right: 10px;
    }

    .footer-section { margin-top: 50px; }
    .remarks {
        font-size: 12px;
        color: #666;
    }
    .remarks p { margin-top: 5px; font-style: italic; }
    .signature {
        border-top: 1px solid #1a1c1e;
        display: inline-block;
        padding-top: 8px;
        min-width: 200px;
        text-align: center;
    }

    .system-gen {
        text-align: center;
        font-size: 11px;
        color: #aaa;
        margin-top: 60px;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .table-fixed { table-layout: fixed; }
    .border-collapse { border-collapse: collapse; }

    @media print {
        body { background: white !important; }
        .container-fluid { padding: 0 !important; }
        .payslip-wrapper { background: white !important; padding: 0 !important; }
        .payslip-container { box-shadow: none !important; border: none !important; width: 100% !important; max-width: 100% !important; padding: 0 !important; }
        .sidebar, .topbar, .btn, .d-print-none { display: none !important; }
        .main-wrapper, .main-content { margin: 0 !important; padding: 0 !important; }
    }
</style>
@endsection
