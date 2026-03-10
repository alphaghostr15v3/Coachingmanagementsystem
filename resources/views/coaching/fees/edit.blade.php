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

@php
    $existingGstType = $fee->gst_type ?? 'none';
    if ($fee->igst_rate > 0)        $existingGstType = 'inter';
    elseif ($fee->cgst_rate > 0)    $existingGstType = 'intra';
    else                            $existingGstType = 'none';
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.fees.update', $fee) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Student & Date --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="student_id" class="form-label fw-bold small text-uppercase text-secondary">Student <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('student_id') is-invalid @enderror" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"
                                        data-state="{{ $student->state ?? '' }}"
                                        {{ old('student_id', $fee->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                        @if($student->state) ({{ $student->state }}) @endif
                                    </option>
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

                    {{-- Amount & Status --}}
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
                                <option value="paid"   {{ old('status', $fee->status) == 'paid'   ? 'selected' : '' }}>Full Paid</option>
                                <option value="unpaid" {{ old('status', $fee->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- GST State Banner --}}
                    <div id="gst_state_banner" class="alert alert-info d-flex align-items-center gap-2 rounded-4 mb-4">
                        <i class="fas fa-info-circle fs-5"></i>
                        <span id="gst_state_msg">
                            @if($fee->student_state && $fee->institute_state)
                                Saved: Student State <strong>{{ $fee->student_state }}</strong> |
                                Institute State <strong>{{ $fee->institute_state }}</strong> &mdash;
                                @if(strtolower($fee->student_state) === strtolower($fee->institute_state))
                                    <span class="badge bg-success">Intra-State (CGST+SGST)</span>
                                @else
                                    <span class="badge bg-warning text-dark">Inter-State (IGST)</span>
                                @endif
                            @else
                                Select a student to auto-detect GST type.
                            @endif
                        </span>
                    </div>

                    {{-- GST Details --}}
                    <div class="bg-light rounded-4 p-4 mb-5 border border-primary border-opacity-10">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0 text-primary small text-uppercase letter-spacing-1">GST Details</h5>
                            {{-- GST Type Toggle --}}
                            <div class="d-flex gap-2 align-items-center">
                                <span class="small text-muted me-1">GST Type:</span>
                                <div class="btn-group btn-group-sm" role="group">
                                    <input type="radio" class="btn-check" name="gst_type_toggle" id="gst_intra" value="intra" autocomplete="off" {{ $existingGstType === 'intra' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success" for="gst_intra">
                                        <i class="fas fa-map-marker-alt me-1"></i> Intra-State (CGST+SGST)
                                    </label>
                                    <input type="radio" class="btn-check" name="gst_type_toggle" id="gst_inter" value="inter" autocomplete="off" {{ $existingGstType === 'inter' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning" for="gst_inter">
                                        <i class="fas fa-exchange-alt me-1"></i> Inter-State (IGST)
                                    </label>
                                    <input type="radio" class="btn-check" name="gst_type_toggle" id="gst_none" value="none" autocomplete="off" {{ $existingGstType === 'none' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary" for="gst_none">
                                        <i class="fas fa-ban me-1"></i> No GST
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Rate Buttons --}}
                        <div class="mb-3">
                            <label class="small fw-bold text-secondary mb-2 d-block">Quick Select GST Rate</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach([5, 12, 18, 28] as $rate)
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 quick-rate-btn" data-rate="{{ $rate }}">
                                        {{ $rate }}%
                                    </button>
                                @endforeach
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="custom_rate_btn">Custom</button>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4" id="cgst_col">
                                <label class="form-label small fw-bold text-secondary">CGST (%)</label>
                                <input type="number" step="0.01" name="cgst_rate" id="cgst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('cgst_rate', $fee->cgst_rate) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="cgst_amt_label">{{ number_format($fee->cgst_amount, 2) }}</span></div>
                                <input type="hidden" name="cgst_amount" id="cgst_amount" value="{{ $fee->cgst_amount }}">
                            </div>
                            <div class="col-md-4" id="sgst_col">
                                <label class="form-label small fw-bold text-secondary">SGST (%)</label>
                                <input type="number" step="0.01" name="sgst_rate" id="sgst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('sgst_rate', $fee->sgst_rate) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="sgst_amt_label">{{ number_format($fee->sgst_amount, 2) }}</span></div>
                                <input type="hidden" name="sgst_amount" id="sgst_amount" value="{{ $fee->sgst_amount }}">
                            </div>
                            <div class="col-md-4" id="igst_col">
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
                        const INSTITUTE_STATE = "{{ $instituteState }}";

                        const amountInput   = document.getElementById('amount');
                        const cgstRateInput = document.getElementById('cgst_rate');
                        const sgstRateInput = document.getElementById('sgst_rate');
                        const igstRateInput = document.getElementById('igst_rate');

                        const cgstAmtLabel  = document.getElementById('cgst_amt_label');
                        const sgstAmtLabel  = document.getElementById('sgst_amt_label');
                        const igstAmtLabel  = document.getElementById('igst_amt_label');

                        const cgstAmtInput  = document.getElementById('cgst_amount');
                        const sgstAmtInput  = document.getElementById('sgst_amount');
                        const igstAmtInput  = document.getElementById('igst_amount');

                        const totalLabel    = document.getElementById('total_amount_label');
                        const totalInput    = document.getElementById('total_amount');

                        const gstBanner     = document.getElementById('gst_state_banner');
                        const gstStateMsg   = document.getElementById('gst_state_msg');
                        const studentSelect = document.getElementById('student_id');

                        const cgstCol = document.getElementById('cgst_col');
                        const sgstCol = document.getElementById('sgst_col');
                        const igstCol = document.getElementById('igst_col');

                        function calculateGST() {
                            const base  = parseFloat(amountInput.value) || 0;
                            const cr    = parseFloat(cgstRateInput.value) || 0;
                            const sr    = parseFloat(sgstRateInput.value) || 0;
                            const ir    = parseFloat(igstRateInput.value) || 0;

                            const ca    = parseFloat((base * cr / 100).toFixed(2));
                            const sa    = parseFloat((base * sr / 100).toFixed(2));
                            const ia    = parseFloat((base * ir / 100).toFixed(2));
                            const total = +(base + ca + sa + ia).toFixed(2);

                            cgstAmtLabel.textContent = ca.toFixed(2);
                            sgstAmtLabel.textContent = sa.toFixed(2);
                            igstAmtLabel.textContent = ia.toFixed(2);

                            cgstAmtInput.value = ca.toFixed(2);
                            sgstAmtInput.value = sa.toFixed(2);
                            igstAmtInput.value = ia.toFixed(2);

                            totalLabel.textContent = total.toFixed(2);
                            totalInput.value       = total.toFixed(2);
                        }

                        function applyGstMode(mode) {
                            if (mode === 'intra') {
                                cgstCol.style.opacity = '1'; cgstRateInput.disabled = false;
                                sgstCol.style.opacity = '1'; sgstRateInput.disabled = false;
                                igstCol.style.opacity = '0.4'; igstRateInput.disabled = true; igstRateInput.value = 0;
                            } else if (mode === 'inter') {
                                cgstCol.style.opacity = '0.4'; cgstRateInput.disabled = true; cgstRateInput.value = 0;
                                sgstCol.style.opacity = '0.4'; sgstRateInput.disabled = true; sgstRateInput.value = 0;
                                igstCol.style.opacity = '1'; igstRateInput.disabled = false;
                            } else {
                                cgstCol.style.opacity = '0.4'; cgstRateInput.disabled = true; cgstRateInput.value = 0;
                                sgstCol.style.opacity = '0.4'; sgstRateInput.disabled = true; sgstRateInput.value = 0;
                                igstCol.style.opacity = '0.4'; igstRateInput.disabled = true; igstRateInput.value = 0;
                            }
                            calculateGST();
                        }

                        studentSelect.addEventListener('change', function () {
                            const selected     = this.options[this.selectedIndex];
                            const studentState = (selected.dataset.state || '').trim().toLowerCase();
                            const instState    = INSTITUTE_STATE.trim().toLowerCase();

                            gstBanner.classList.remove('alert-info', 'alert-success', 'alert-warning');

                            if (!studentState || !instState) {
                                gstBanner.classList.add('alert-info');
                                gstStateMsg.innerHTML = '<strong>Note:</strong> Student or institute state not set.';
                                return;
                            }

                            if (studentState === instState) {
                                document.getElementById('gst_intra').checked = true;
                                gstBanner.classList.add('alert-success');
                                gstStateMsg.innerHTML = '<strong>Intra-State</strong> — <strong>' + selected.dataset.state + '</strong> = <strong>' + INSTITUTE_STATE + '</strong>. <span class="badge bg-success">CGST + SGST</span>';
                                applyGstMode('intra');
                            } else {
                                document.getElementById('gst_inter').checked = true;
                                gstBanner.classList.add('alert-warning');
                                gstStateMsg.innerHTML = '<strong>Inter-State</strong> — <strong>' + selected.dataset.state + '</strong> ≠ <strong>' + INSTITUTE_STATE + '</strong>. <span class="badge bg-warning text-dark">IGST</span>';
                                applyGstMode('inter');
                            }
                        });

                        document.querySelectorAll('input[name="gst_type_toggle"]').forEach(function(radio) {
                            radio.addEventListener('change', function () { applyGstMode(this.value); });
                        });

                        document.querySelectorAll('.quick-rate-btn').forEach(function(btn) {
                            btn.addEventListener('click', function () {
                                const rate = parseFloat(this.dataset.rate);
                                const mode = document.querySelector('input[name="gst_type_toggle"]:checked').value;
                                if (mode === 'intra') {
                                    const half = rate / 2;
                                    cgstRateInput.value = half.toFixed(2);
                                    sgstRateInput.value = half.toFixed(2);
                                } else if (mode === 'inter') {
                                    igstRateInput.value = rate.toFixed(2);
                                } else {
                                    document.getElementById('gst_intra').checked = true;
                                    applyGstMode('intra');
                                    const half = rate / 2;
                                    cgstRateInput.value = half.toFixed(2);
                                    sgstRateInput.value = half.toFixed(2);
                                }
                                document.querySelectorAll('.quick-rate-btn').forEach(b => b.classList.remove('active','btn-primary'));
                                this.classList.add('active', 'btn-primary');
                                this.classList.remove('btn-outline-primary');
                                calculateGST();
                            });
                        });

                        document.getElementById('custom_rate_btn').addEventListener('click', function () {
                            document.querySelectorAll('.quick-rate-btn').forEach(b => {
                                b.classList.remove('active', 'btn-primary');
                                b.classList.add('btn-outline-primary');
                            });
                        });

                        [amountInput, cgstRateInput, sgstRateInput, igstRateInput].forEach(function(el) {
                            el.addEventListener('input', calculateGST);
                        });

                        // Init existing mode
                        applyGstMode('{{ $existingGstType }}');
                    </script>
                    @endpush
                </form>
            </div>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-dark text-white animate__animated animate__fadeInRight">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing:1px; font-size:0.75rem;">
                    <i class="fas fa-info-circle me-2 text-primary"></i>GST Logic (India)
                </h6>
                <ul class="list-unstyled small text-white text-opacity-75 mb-0" style="line-height:2;">
                    <li><span class="badge bg-success me-2">INTRA</span>Same State → <strong>CGST + SGST</strong></li>
                    <li><span class="badge bg-warning text-dark me-2">INTER</span>Diff. State → <strong>IGST</strong></li>
                </ul>
                <hr class="border-secondary my-3">
                <div class="small text-white text-opacity-50">
                    <i class="fas fa-university me-2"></i>
                    <strong>Institute State:</strong>
                    {{ $instituteState ?: 'Not Set' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
