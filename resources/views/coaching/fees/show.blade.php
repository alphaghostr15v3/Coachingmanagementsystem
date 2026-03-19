@extends('layouts.coaching')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center animate__animated animate__fadeIn no-print">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('coaching.fees.index') }}" class="text-decoration-none">Fees</a></li>
                <li class="breadcrumb-item active">Invoice #{{ $fee->id }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-0">Fee Invoice</h2>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('coaching.fees.download', $fee) }}" class="btn btn-outline-danger shadow-sm px-4">
            <i class="fas fa-file-pdf me-2"></i> Download PDF
        </a>
        <button onclick="window.print()" class="btn btn-primary shadow-sm px-4">
            <i class="fas fa-print me-2"></i> Print Invoice
        </button>
        <a href="{{ route('coaching.fees.index') }}" class="btn btn-light border px-4">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp overflow-hidden">
    <!-- Invoice Header -->
    <div class="card-header bg-dark p-4 p-md-5 border-0 text-white">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <h1 class="fw-black mb-1 display-4" style="letter-spacing: -2px;">INVOICE</h1>
                <p class="text-white text-opacity-75 mb-0 font-monospace">#INV-{{ str_pad($fee->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h4 class="fw-bold mb-1">{{ auth()->user()->coaching->coaching_name ?? 'Coaching System' }}</h4>
                <p class="text-white text-opacity-75 mb-0 small">
                    @php
                        $coaching = auth()->user()->coaching;
                        // If coaching exists, strictly use its gst_number (even if null). Otherwise fallback to fee for students.
                        $displayGst = $coaching ? $coaching->gst_number : $fee->institute_gst_number;
                    @endphp
                    @if(!empty(trim($displayGst)))
                        GSTIN: <strong>{{ $displayGst }}</strong><br>
                    @endif
                    Date: {{ \Carbon\Carbon::parse($fee->date)->format('d M, Y') }}<br>
                    Status: <span class="badge {{ $fee->status === 'paid' ? 'bg-success' : 'bg-danger' }} text-uppercase ms-1 px-2 py-1" style="font-size: 0.65rem;">{{ $fee->status }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Invoice Body -->
    <div class="card-body p-4 p-md-5">
        <div class="row mb-5">
            <div class="col-md-6">
                <p class="text-secondary fw-bold text-uppercase mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">Invoice To:</p>
                <h4 class="fw-bold mb-1" style="color: #1a1c1e;">{{ $fee->student->name }}</h4>
                <p class="text-muted small mb-1">Student ID: #STU{{ str_pad($fee->student_id, 4, '0', STR_PAD_LEFT) }}</p>
                <p class="text-muted small">Email: {{ $fee->student->email ?? 'N/A' }}</p>
                @if($fee->student_state)
                <p class="text-muted small">State: <span class="fw-medium text-dark">{{ $fee->student_state }}</span></p>
                @endif
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-secondary fw-bold text-uppercase mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">Payment Details:</p>
                <p class="text-muted small mb-1">Payment Method: <span class="text-dark fw-medium">Offline/Cash</span></p>
                <p class="text-muted small mb-1">Currency: <span class="text-dark fw-medium">INR (₹)</span></p>
                @php
                    $hasTax = ($fee->cgst_amount + $fee->sgst_amount + $fee->igst_amount) > 0;
                @endphp
                @if($hasTax && $fee->gst_type)
                <p class="text-muted small">
                    GST Type: 
                        @if($fee->gst_type === 'inter')
                            <span class="badge bg-warning text-dark">Inter-State (IGST)</span>
                        @else
                            <span class="badge bg-success">Intra-State (CGST+SGST)</span>
                        @endif
                        @php
                            $coaching = auth()->user()->coaching;
                            $displayState = $coaching ? $coaching->state : $fee->institute_state;
                        @endphp
                        @if($displayState) &nbsp;| Institute: <strong>{{ $displayState }}</strong> @endif
                    </p>
                @endif
            </div>
        </div>

        <div class="table-responsive mb-5">
            <table class="table table-borderless">
                <thead>
                    <tr class="border-bottom">
                        <th class="pb-3 text-secondary small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Description</th>
                        <th class="pb-3 text-center text-secondary small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">HSN/SAC</th>
                        <th class="pb-3 text-end text-secondary small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Amount</th>
                    </tr>
                </thead>
                <tbody class="border-bottom">
                    <tr>
                        <td class="py-4">
                            <h6 class="fw-bold mb-1" style="color: #1a1c1e;">Coaching / Tuition Fee</h6>
                            <p class="text-muted small mb-0">Course: {{ $fee->student->course->name ?? 'Active Course' }} | Billing: <span class="text-primary fw-bold text-uppercase">{{ $fee->billing_cycle }}</span></p>
                        </td>
                        <td class="py-4 text-center align-middle text-muted">999293</td>
                        <td class="py-4 text-end align-middle fw-bold" style="font-size: 1.1rem; color: #1a1c1e;">₹{{ number_format($fee->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row pt-2 pb-5">
            <div class="col-md-6">
                <h6 class="fw-bold mb-3 text-uppercase" style="font-size: 0.75rem; color: #1a1c1e; letter-spacing: 1px;">Terms & Conditions</h6>
                <ul class="text-muted small ps-3 mb-0" style="line-height: 1.8;">
                    <li class="mb-2">Fees once paid are non-refundable and non-transferable.</li>
                    <li class="mb-2">This is a computer-generated invoice and doesn't require a signature.</li>
                    <li>Please keep this invoice for future reference.</li>
                </ul>
            </div>
            <div class="col-md-5 offset-md-1">
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted" style="font-size: 0.9rem;">Subtotal (Base):</span>
                    <span class="fw-bold" style="color: #1a1c1e;">₹{{ number_format($fee->amount, 2) }}</span>
                </div>

                @if($fee->cgst_amount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">CGST ({{ number_format($fee->cgst_rate, 2) }}%):</span>
                    <span class="text-muted small">₹{{ number_format($fee->cgst_amount, 2) }}</span>
                </div>
                @endif

                @if($fee->sgst_amount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">SGST ({{ number_format($fee->sgst_rate, 2) }}%):</span>
                    <span class="text-muted small">₹{{ number_format($fee->sgst_amount, 2) }}</span>
                </div>
                @endif

                @if($fee->igst_amount > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">IGST ({{ number_format($fee->igst_rate, 2) }}%):</span>
                    <span class="text-muted small">₹{{ number_format($fee->igst_amount, 2) }}</span>
                </div>
                @endif

                <div class="mt-4 pt-4 d-flex justify-content-between align-items-center border-top">
                    <h3 class="fw-bold mb-0" style="color: #1a1c1e; font-size: 1.75rem;">Total:</h3>
                    <h2 class="fw-black mb-0" style="color: #2563eb; font-size: 2.5rem;">₹{{ number_format($fee->total_amount, 2) }}</h2>
                </div>
            </div>
        </div>

        <div class="text-center pt-5 border-top">
            <p class="text-muted small mb-0">Thank you for choosing our services.</p>
        </div>
    </div>
</div>

<style>
    @media print {
        @page {
            size: A4;
            margin: 1cm;
        }
        /* Hide all layout elements */
        .no-print, .sidebar, .topbar, footer, .btn, .breadcrumb { display: none !important; }
        
        /* Reset layout for full width */
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; width: 100% !important; }
        .main-content { padding: 0 !important; }
        
        /* Invoice styling for paper */
        body { background: white !important; -webkit-print-color-adjust: exact !important; color-adjust: exact !important; margin: 0 !important; padding: 0 !important; font-size: 10pt !important; }
        .card { box-shadow: none !important; border: 1px solid #1a1c1e !important; transform: none !important; margin: 0 !important; page-break-inside: avoid !important; width: 100% !important; }
        .bg-dark { background-color: #1a1c1e !important; color: white !important; -webkit-print-color-adjust: exact !important; }
        [style*="color: #2563eb"] { color: #2563eb !important; -webkit-print-color-adjust: exact !important; }
        
        .container-fluid, .container { max-width: 100% !important; width: 100% !important; padding: 0 !important; margin: 0 !important; }
        .card-header { padding: 0.75rem 1.5rem !important; }
        .card-body { padding: 1rem 1.5rem !important; }
        .mb-5 { margin-bottom: 0.5rem !important; }
        .pb-5 { padding-bottom: 0.5rem !important; }
        .pt-5 { padding-top: 0.25rem !important; }
        .py-4 { padding-top: 0.25rem !important; padding-bottom: 0.25rem !important; }
        .mb-3 { margin-bottom: 0.25rem !important; }
        .mt-4 { margin-top: 0.5rem !important; }
        .pt-4 { padding-top: 0.5rem !important; }
        
        h1.display-4 { font-size: 1.75rem !important; }
        h2 { font-size: 1.25rem !important; }
        h3 { font-size: 1rem !important; }
        .h4, h4 { font-size: 0.9rem !important; }
        .row.mb-5 { margin-bottom: 0.5rem !important; }
        .table-responsive.mb-5 { margin-bottom: 0.5rem !important; }
        
        .small { font-size: 0.75rem !important; }
        p { margin-bottom: 0.25rem !important; }
        
        /* Ensure summary and terms stay on one page */
        .row { page-break-inside: avoid !important; }
        .card-body > .row:last-of-type { 
            margin-top: 0.25rem !important;
            padding-top: 0 !important;
        }
        
        /* Reduce gap in terms list */
        ul.ps-3 li { margin-bottom: 0.1rem !important; font-size: 8pt !important; }
    }
    .fw-black { font-weight: 900; }
    .letter-spacing-1 { letter-spacing: 1px; }
</style>
@endsection
