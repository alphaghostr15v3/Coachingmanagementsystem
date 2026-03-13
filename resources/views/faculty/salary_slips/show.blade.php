@extends('layouts.faculty')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2 d-print-none">
        <a href="{{ route('faculty.salary-slips.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Back to Slips
        </a>
        <div class="d-flex">
            <a href="{{ route('faculty.salary-slips.download', $salarySlip->id) }}" class="btn btn-outline-danger shadow-sm rounded-pill px-4 me-2">
                <i class="fas fa-file-pdf me-2"></i> Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="fas fa-print me-2"></i> Print Slip
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden" id="printableArea">
                <div class="card-body p-5">
                    
                    <!-- Header -->
                    <div class="text-center border-bottom border-2 border-dark pb-4 mb-4">
                        <h2 class="fw-bold mb-1 text-uppercase letter-spacing-1">{{ $currentCoaching->coaching_name ?? 'Coaching Center' }}</h2>
                        <p class="mb-0 text-muted">{{ $currentCoaching->address ?? 'Address Not Set' }}</p>
                        <p class="mb-0 text-muted">Phone: {{ $currentCoaching->mobile ?? 'N/A' }} | Email: {{ $currentCoaching->email ?? 'N/A' }}</p>
                        <h4 class="mt-4 fw-bold text-decoration-underline text-uppercase bg-light d-inline-block px-4 py-2 rounded">Payslip</h4>
                    </div>

                    <!-- Details -->
                    <div class="row mb-5 text-start">
                        <div class="col-md-6 border-end border-light">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 ls-1">Employee Details</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="40%" class="text-muted">Employee Name</th>
                                    <td class="fw-bold">: {{ $salarySlip->faculty->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Email</th>
                                    <td>: {{ $salarySlip->faculty->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Designation</th>
                                    <td>: Faculty</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Employee ID</th>
                                    <td>: #{{ str_pad($salarySlip->faculty_id, 4, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 ms-auto ps-md-4">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 ls-1">Payslip Details</h6>
                            <table class="table table-sm table-borderless">
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
                                    <td>: {{ $salarySlip->payment_date ? $salarySlip->payment_date->format('d F, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Status</th>
                                    <td class="fw-bold text-{{ $salarySlip->payment_status === 'Paid' ? 'success' : 'warning' }}">: {{ strtoupper($salarySlip->payment_status) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Salary Breakdown -->
                    <div class="row mb-4">
                        <div class="col-md-6 pe-md-0">
                            <div class="border h-100">
                                <table class="table mb-0 text-start">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Earnings</th>
                                            <th class="text-end">Amount (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Basic Salary</td>
                                            <td class="text-end fw-bold">{{ number_format($salarySlip->basic_salary, 2) }}</td>
                                        </tr>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6 ps-md-0">
                            <div class="border border-start-0 h-100">
                                <table class="table mb-0 text-start">
                                    <thead class="table-light">
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
                    </div>

                    <!-- Totals -->
                    <div class="row border mx-0 border-top-0 mb-5 text-uppercase bg-light">
                        <div class="col-6 py-3 border-end">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total Earnings:</span>
                                <span>₹{{ number_format($salarySlip->basic_salary + $totalEarnings, 2) }}</span>
                            </div>
                        </div>
                        <div class="col-6 py-3">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total Deductions:</span>
                                <span>₹{{ number_format($totalDeductions, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Net Pay -->
                    <div class="bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-4 p-4 mb-5 text-center">
                        <p class="text-muted text-uppercase fw-bold mb-1">Net Salary Paid</p>
                        <h1 class="display-5 fw-bold text-primary mb-0">₹{{ number_format($salarySlip->net_salary, 2) }}</h1>
                    </div>

                    <!-- Remarks & Signs -->
                    <div class="row align-items-end mt-5 pt-3">
                        <div class="col-md-6 text-start">
                            @if($salarySlip->remarks)
                                <h6 class="fw-bold text-muted text-uppercase small ls-1">Remarks:</h6>
                                <p class="fst-italic border-start border-3 border-primary ps-3 text-muted">{{ $salarySlip->remarks }}</p>
                            @endif
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="d-inline-block border-top border-dark text-center pt-2" style="min-width: 200px;">
                                <p class="mb-0 fw-bold">Authorized Signatory</p>
                                <small class="text-muted">{{ $currentCoaching->coaching_name ?? 'Management' }}</small>
                            </div>
                        </div>
                    </div>

                    <p class="text-center text-muted small mt-5 mb-0">This is a system generated payslip and does not require a physical signature.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .topbar, .btn, .d-print-none { display: none !important; }
        .main-wrapper { margin-left: 0 !important; }
        .main-content { padding: 0 !important; }
        .card { border: none !important; shadow: none !important; }
        body { background: white !important; }
    }
    
    .table th:last-child, .table td:last-child {
        padding-right: 15px !important;
        white-space: nowrap;
    }
</style>
@endsection
