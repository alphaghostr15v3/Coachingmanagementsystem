@extends('layouts.coaching')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2 d-print-none">
        <a href="{{ route('coaching.salary-slips.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Back to Slips
        </a>
        <div class="d-flex">
            <a href="{{ route('coaching.salary-slips.download', $salarySlip->id) }}" class="btn btn-outline-danger shadow-sm rounded-pill px-4 me-2">
                <i class="fas fa-file-pdf me-2"></i> Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-print me-2"></i> Print Slip
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Printable Salary Slip -->
            <div class="card border border-light shadow-sm rounded-0 bg-white" id="printableArea">
                <div class="card-body p-5">
                    
                    <!-- Header -->
                    <div class="text-center border-bottom border-2 border-dark pb-4 mb-4">
                        <h2 class="fw-bold mb-1 text-uppercase letter-spacing-1">{{ $currentCoaching->coaching_name ?? 'Coaching Center' }}</h2>
                        <p class="mb-0 text-muted">{{ $currentCoaching->address ?? 'Address Line 1, City, State ZIP' }}</p>
                        <p class="mb-0 text-muted">Phone: {{ $currentCoaching->phone ?? 'N/A' }} | Email: {{ $currentCoaching->email ?? 'N/A' }}</p>
                        <h4 class="mt-4 fw-bold text-decoration-underline text-uppercase bg-light d-inline-block px-4 py-2 rounded">Payslip</h4>
                    </div>

                    <!-- Employee & Payslip Details -->
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 ls-1">Employee Details</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="40%" class="text-muted">Employee Name</th>
                                    <td class="fw-bold">: {{ $salarySlip->teacher->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Email</th>
                                    <td>: {{ $salarySlip->teacher->email }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Designation</th>
                                    <td>: Teacher / Faculty</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Employee ID</th>
                                    <td>: #{{ str_pad($salarySlip->teacher->id, 4, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 border-start border-light pt-md-0 pt-4">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 ls-1 ps-md-3">Payslip Details</h6>
                            <table class="table table-sm table-borderless ms-md-3">
                                <tr>
                                    <th width="40%" class="text-muted">Payslip No.</th>
                                    <td class="fw-bold">: #{{ str_pad($salarySlip->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Earnings Period</th>
                                    <td class="fw-bold text-primary">: {{ $salarySlip->month }} {{ $salarySlip->year }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Payment Date</th>
                                    <td>: {{ $salarySlip->payment_date->format('d F, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Status</th>
                                    <td class="fw-bold text-{{ $salarySlip->payment_status === 'Paid' ? 'success' : 'warning' }}">: {{ mb_strtoupper($salarySlip->payment_status) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Salary Breakdown -->
                    <div class="row mb-4">
                        <!-- Earnings Column -->
                        <div class="col-md-6 pr-md-0 pe-md-0">
                            <div class="border h-100">
                                <table class="table mb-0">
                                    <thead class="table-light border-bottom">
                                        <tr>
                                            <th>Earnings</th>
                                            <th class="text-end">Amount (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Basic Salary</td>
                                            <td class="text-end fw-bold">₹{{ number_format($salarySlip->basic_salary, 2) }}</td>
                                        </tr>
                                        @if($salarySlip->total_days > 0 && $salarySlip->per_day_pay > 0)
                                        <tr>
                                            <td class="ps-4 py-0 small text-muted">
                                                <i class="fas fa-info-circle me-1"></i> Calculation: {{ $salarySlip->total_days }} days × ₹{{ number_format($salarySlip->per_day_pay, 2) }} /day
                                            </td>
                                            <td class="py-0"></td>
                                        </tr>
                                        @endif
                                        @php $totalEarnings = 0; @endphp
                                        @if(is_array($salarySlip->earnings))
                                            @foreach($salarySlip->earnings as $earning)
                                                <tr>
                                                    <td>{{ $earning['name'] }}</td>
                                                    <td class="text-end">{{ number_format($earning['amount'], 2) }}</td>
                                                </tr>
                                                @php $totalEarnings += (float)$earning['amount']; @endphp
                                            @endforeach
                                        @endif
                                        <!-- Padding rows if needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Deductions Column -->
                        <div class="col-md-6 pl-md-0 ps-md-0">
                            <div class="border border-start-0 h-100">
                                <table class="table mb-0">
                                    <thead class="table-light border-bottom">
                                        <tr>
                                            <th>Deductions</th>
                                            <th class="text-end">Amount (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalDeductions = 0; @endphp
                                        @if(is_array($salarySlip->deductions))
                                            @foreach($salarySlip->deductions as $deduction)
                                                <tr>
                                                    <td>{{ $deduction['name'] }}</td>
                                                    <td class="text-end">{{ number_format($deduction['amount'], 2) }}</td>
                                                </tr>
                                                @php $totalDeductions += (float)$deduction['amount']; @endphp
                                            @endforeach
                                        @endif
                                        @if(empty($salarySlip->deductions))
                                            <tr>
                                                <td class="text-muted fst-italic">No deductions</td>
                                                <td class="text-end">0.00</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- End Breakdown Row -->

                    <!-- Totals Row -->
                    <div class="row border mx-0 border-top-0 mb-5 text-uppercase mb-2 bg-light">
                        <div class="col-6 py-2 border-end">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total Earnings:</span>
                                <span>₹{{ number_format($salarySlip->basic_salary + $totalEarnings, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-6 py-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total Deductions:</span>
                                <span>₹{{ number_format($totalDeductions, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Net Salary Alert Block -->
                    <div class="alert bg-soft-primary border border-primary my-4 p-4 row text-center rounded-3 bg-opacity-10">
                         <div class="col-12 py-1">
                             <p class="text-muted text-uppercase fw-bold letter-spacing-1 mb-1">Net Salary Transfer</p>
                             <h1 class="display-5 fw-bold text-primary mb-0">₹{{ number_format($salarySlip->net_salary, 2) }}</h1>
                         </div>
                    </div>

                    <!-- Remarks & Signatures -->
                    <div class="row mt-5 pt-4">
                        <div class="col-md-6">
                            @if($salarySlip->remarks)
                                <h6 class="fw-bold text-muted text-uppercase ls-1">Remarks:</h6>
                                <p class="fst-italic border-start border-3 border-primary ps-3">{{ $salarySlip->remarks }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="mt-4 pt-3 d-inline-block border-top border-dark text-center" style="min-width: 200px;">
                                <p class="mb-0 fw-bold">Authorized Signatory</p>
                                <small class="text-muted">{{ $currentCoaching->coaching_name ?? 'Management' }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-5 pt-3 border-top border-light text-muted small pb-2">
                        <p class="mb-0">This is a system generated payslip.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Print specific styles */
    @media print {
        body { background-color: white !important; }
        .sidebar, .topbar, .btn { display: none !important; }
        .main-wrapper { margin-left: 0 !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; padding: 0 !important; margin: 0 !important;}
        .card-body { padding: 0.5in !important; }
        .alert { page-break-inside: avoid; border: 1px solid #0d6efd !important; background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }

    /* Fix for amount truncation */
    .table th:last-child, 
    .table td:last-child {
        padding-right: 20px !important;
        white-space: nowrap;
    }
    
    #printableArea {
        overflow: visible !important;
    }
</style>
@endsection
