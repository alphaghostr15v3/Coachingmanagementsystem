@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.fees.index') }}" class="text-decoration-none">Fees</a></li>
            <li class="breadcrumb-item active">Edit Record</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Update Payment Record</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.fees.update', $fee) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="student_id" class="form-label fw-bold small text-uppercase text-secondary">Student <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('student_id') is-invalid @enderror" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $fee->student_id) == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-bold small text-uppercase text-secondary">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control form-control-lg border-0 bg-light rounded-4 @error('date') is-invalid @enderror" value="{{ old('date', $fee->date) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="amount" class="form-label fw-bold small text-uppercase text-secondary">Base Amount (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light rounded-start-4">₹</span>
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control form-control-lg border-0 bg-light rounded-end-4 @error('amount') is-invalid @enderror" value="{{ old('amount', $fee->amount) }}" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold small text-uppercase text-secondary">Payment Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select form-select-lg border-0 bg-light rounded-4 @error('status') is-invalid @enderror" required>
                                <option value="paid" {{ old('status', $fee->status) == 'paid' ? 'selected' : '' }}>Full Paid</option>
                                <option value="unpaid" {{ old('status', $fee->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-light rounded-4 p-4 mb-5 border border-primary border-opacity-10">
                        <h5 class="fw-bold mb-4 text-primary small text-uppercase letter-spacing-1">GST Details</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">CGST (%)</label>
                                <input type="number" step="0.01" name="cgst_rate" id="cgst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('cgst_rate', $fee->cgst_rate) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="cgst_amt_label">{{ number_format($fee->cgst_amount, 2) }}</span></div>
                                <input type="hidden" name="cgst_amount" id="cgst_amount" value="{{ $fee->cgst_amount }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">SGST (%)</label>
                                <input type="number" step="0.01" name="sgst_rate" id="sgst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('sgst_rate', $fee->sgst_rate) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="sgst_amt_label">{{ number_format($fee->sgst_amount, 2) }}</span></div>
                                <input type="hidden" name="sgst_amount" id="sgst_amount" value="{{ $fee->sgst_amount }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">IGST (%)</label>
                                <input type="number" step="0.01" name="igst_rate" id="igst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('igst_rate', $fee->igst_rate) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="igst_amt_label">{{ number_format($fee->igst_amount, 2) }}</span></div>
                                <input type="hidden" name="igst_amount" id="igst_amount" value="{{ $fee->igst_amount }}">
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top border-primary border-opacity-10 d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold mb-0">Total Amount:</h4>
                            <h3 class="fw-black text-primary mb-0">₹<span id="total_amount_label">{{ number_format($fee->total_amount, 2) }}</span></h3>
                            <input type="hidden" name="total_amount" id="total_amount" value="{{ $fee->total_amount }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('coaching.fees.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Back</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-sync-alt me-2"></i> Update Record
                        </button>
                    </div>

                    @push('scripts')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const amountInput = document.getElementById('amount');
                            const cgstRate = document.getElementById('cgst_rate');
                            const sgstRate = document.getElementById('sgst_rate');
                            const igstRate = document.getElementById('igst_rate');
                            
                            const cgstAmtLabel = document.getElementById('cgst_amt_label');
                            const sgstAmtLabel = document.getElementById('sgst_amt_label');
                            const igstAmtLabel = document.getElementById('igst_amt_label');
                            
                            const cgstAmtInput = document.getElementById('cgst_amount');
                            const sgstAmtInput = document.getElementById('sgst_amount');
                            const igstAmtInput = document.getElementById('igst_amount');
                            
                            const totalAmountLabel = document.getElementById('total_amount_label');
                            const totalAmountInput = document.getElementById('total_amount');

                            function calculateGST() {
                                const base = parseFloat(amountInput.value) || 0;
                                const cr = parseFloat(cgstRate.value) || 0;
                                const sr = parseFloat(sgstRate.value) || 0;
                                const ir = parseFloat(igstRate.value) || 0;

                                const ca = (base * cr) / 100;
                                const sa = (base * sr) / 100;
                                const ia = (base * ir) / 100;
                                const total = base + ca + sa + ia;

                                cgstAmtLabel.textContent = ca.toFixed(2);
                                sgstAmtLabel.textContent = sa.toFixed(2);
                                igstAmtLabel.textContent = ia.toFixed(2);
                                
                                cgstAmtInput.value = ca.toFixed(2);
                                sgstAmtInput.value = sa.toFixed(2);
                                igstAmtInput.value = ia.toFixed(2);
                                
                                totalAmountLabel.textContent = total.toFixed(2);
                                totalAmountInput.value = total.toFixed(2);
                            }

                            [amountInput, cgstRate, sgstRate, igstRate].forEach(el => {
                                el.addEventListener('input', calculateGST);
                            });

                            // Pre-fill SGST if CGST is changed for intra-state common case (9+9)
                            cgstRate.addEventListener('change', function() {
                                if (parseFloat(igstRate.value) === 0 && (parseFloat(sgstRate.value) === 0 || parseFloat(sgstRate.value) === parseFloat(oldCgstValue))) {
                                    sgstRate.value = this.value;
                                    calculateGST();
                                }
                            });
                            
                            let oldCgstValue = cgstRate.value;
                            cgstRate.addEventListener('focus', function() {
                                oldCgstValue = this.value;
                            });
                        });
                    </script>
                    @endpush
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
