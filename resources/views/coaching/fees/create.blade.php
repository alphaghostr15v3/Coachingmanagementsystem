@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.fees.index') }}" class="text-decoration-none">Fees</a></li>
            <li class="breadcrumb-item active">Collect Fee</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Record Payment</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.fees.store') }}" method="POST">
                    @csrf

                    {{-- Student & Date --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="student_id" class="form-label fw-bold small text-uppercase text-secondary">Student <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('student_id') is-invalid @enderror" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"
                                        data-state="{{ $student->state ?? '' }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}>
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
                            <input type="date" name="date" id="date" class="form-control form-control-lg border-0 bg-light rounded-4 @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
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
                                <input type="number" step="0.01" name="amount" id="amount" class="form-control form-control-lg border-0 bg-light rounded-end-4 @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required placeholder="0.00">
                            </div>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold small text-uppercase text-secondary">Payment Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select form-select-lg border-0 bg-light rounded-4 @error('status') is-invalid @enderror" required>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Full Paid</option>
                                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- GST State Detection Banner --}}
                    <div id="gst_state_banner" class="alert alert-info d-flex align-items-center gap-2 rounded-4 mb-4 d-none">
                        <i class="fas fa-info-circle fs-5"></i>
                        <span id="gst_state_msg">Select a student to auto-detect GST type.</span>
                    </div>

                    {{-- GST Details --}}
                    <div class="bg-light rounded-4 p-4 mb-5 border border-primary border-opacity-10">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0 text-primary small text-uppercase letter-spacing-1">GST Details</h5>
                            {{-- GST Type Toggle --}}
                            <div class="d-flex gap-2 align-items-center">
                                <span class="small text-muted me-1">GST Type:</span>
                                <div class="btn-group btn-group-sm" role="group">
                                    <input type="radio" class="btn-check" name="gst_type_toggle" id="gst_intra" value="intra" autocomplete="off">
                                    <label class="btn btn-outline-success" for="gst_intra">
                                        <i class="fas fa-map-marker-alt me-1"></i> Intra-State (CGST+SGST)
                                    </label>
                                    <input type="radio" class="btn-check" name="gst_type_toggle" id="gst_inter" value="inter" autocomplete="off">
                                    <label class="btn btn-outline-warning" for="gst_inter">
                                        <i class="fas fa-exchange-alt me-1"></i> Inter-State (IGST)
                                    </label>
                                    <input type="radio" class="btn-check" name="gst_type_toggle" id="gst_none" value="none" autocomplete="off" checked>
                                    <label class="btn btn-outline-secondary" for="gst_none">
                                        <i class="fas fa-ban me-1"></i> No GST
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- GST Rate: 5%, 12%, 18%, 28% quick select --}}
                        <div class="mb-3" id="gst_rate_row">
                            <label class="small fw-bold text-secondary mb-2 d-block">Quick Select GST Rate</label>
                            <div class="d-flex flex-wrap gap-2" id="quick_rate_buttons">
                                @foreach([5, 12, 18, 28] as $rate)
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 quick-rate-btn" data-rate="{{ $rate }}">
                                        {{ $rate }}%
                                    </button>
                                @endforeach
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="custom_rate_btn">
                                    Custom
                                </button>
                            </div>
                        </div>

                        <div class="row g-3" id="gst_fields">
                            {{-- CGST --}}
                            <div class="col-md-4" id="cgst_col">
                                <label class="form-label small fw-bold text-secondary">CGST (%)</label>
                                <input type="number" step="0.01" name="cgst_rate" id="cgst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('cgst_rate', 0) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="cgst_amt_label">0.00</span></div>
                                <input type="hidden" name="cgst_amount" id="cgst_amount" value="0">
                            </div>
                            {{-- SGST --}}
                            <div class="col-md-4" id="sgst_col">
                                <label class="form-label small fw-bold text-secondary">SGST (%)</label>
                                <input type="number" step="0.01" name="sgst_rate" id="sgst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('sgst_rate', 0) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="sgst_amt_label">0.00</span></div>
                                <input type="hidden" name="sgst_amount" id="sgst_amount" value="0">
                            </div>
                            {{-- IGST --}}
                            <div class="col-md-4" id="igst_col">
                                <label class="form-label small fw-bold text-secondary">IGST (%)</label>
                                <input type="number" step="0.01" name="igst_rate" id="igst_rate" class="form-control border-white shadow-sm rounded-3" value="{{ old('igst_rate', 0) }}">
                                <div class="small mt-1 text-muted">Amt: ₹<span id="igst_amt_label">0.00</span></div>
                                <input type="hidden" name="igst_amount" id="igst_amount" value="0">
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top border-primary border-opacity-10 d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold mb-0">Total Amount:</h4>
                            <h3 class="fw-black text-primary mb-0">₹<span id="total_amount_label">0.00</span></h3>
                            <input type="hidden" name="total_amount" id="total_amount" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('coaching.fees.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 py-2 rounded-4 fw-bold shadow text-white">
                            <i class="fas fa-file-invoice me-2"></i> Generate Invoice
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

                        const gstIntraRadio = document.getElementById('gst_intra');
                        const gstInterRadio = document.getElementById('gst_inter');
                        const gstNoneRadio  = document.getElementById('gst_none');

                        const cgstCol = document.getElementById('cgst_col');
                        const sgstCol = document.getElementById('sgst_col');
                        const igstCol = document.getElementById('igst_col');

                        // --- Calculate and display GST amounts ---
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

                        // --- Apply GST type mode (enable/disable fields) ---
                        function applyGstMode(mode) {
                            if (mode === 'intra') {
                                // CGST + SGST visible, IGST disabled
                                cgstCol.style.opacity = '1'; cgstRateInput.disabled = false;
                                sgstCol.style.opacity = '1'; sgstRateInput.disabled = false;
                                igstCol.style.opacity = '0.4'; igstRateInput.disabled = true;
                                igstRateInput.value = 0;
                            } else if (mode === 'inter') {
                                // IGST visible, CGST + SGST disabled
                                cgstCol.style.opacity = '0.4'; cgstRateInput.disabled = true; cgstRateInput.value = 0;
                                sgstCol.style.opacity = '0.4'; sgstRateInput.disabled = true; sgstRateInput.value = 0;
                                igstCol.style.opacity = '1'; igstRateInput.disabled = false;
                            } else {
                                // No GST — all zero
                                cgstCol.style.opacity = '0.4'; cgstRateInput.disabled = true; cgstRateInput.value = 0;
                                sgstCol.style.opacity = '0.4'; sgstRateInput.disabled = true; sgstRateInput.value = 0;
                                igstCol.style.opacity = '0.4'; igstRateInput.disabled = true; igstRateInput.value = 0;
                            }
                            calculateGST();
                        }

                        // --- Auto-detect GST type when student is selected ---
                        studentSelect.addEventListener('change', function () {
                            const selected    = this.options[this.selectedIndex];
                            const studentState = (selected.dataset.state || '').trim().toLowerCase();
                            const instState    = INSTITUTE_STATE.trim().toLowerCase();

                            gstBanner.classList.remove('d-none', 'alert-info', 'alert-success', 'alert-warning');

                            if (!studentState || !instState) {
                                gstBanner.classList.add('alert-info');
                                gstStateMsg.innerHTML = '<strong>Note:</strong> Student or institute state not set — GST type not auto-detected. Please select manually.';
                                return;
                            }

                            if (studentState === instState) {
                                // Intra-state
                                gstIntraRadio.checked = true;
                                gstBanner.classList.add('alert-success');
                                gstStateMsg.innerHTML =
                                    '<strong>Intra-State Transaction</strong> — Student state <strong>' + selected.dataset.state +
                                    '</strong> matches institute state <strong>' + INSTITUTE_STATE +
                                    '</strong>. <span class="badge bg-success">CGST + SGST Applied</span>';
                                applyGstMode('intra');
                            } else {
                                // Inter-state
                                gstInterRadio.checked = true;
                                gstBanner.classList.add('alert-warning');
                                gstStateMsg.innerHTML =
                                    '<strong>Inter-State Transaction</strong> — Student state <strong>' + selected.dataset.state +
                                    '</strong> differs from institute state <strong>' + INSTITUTE_STATE +
                                    '</strong>. <span class="badge bg-warning text-dark">IGST Applied</span>';
                                applyGstMode('inter');
                            }
                        });

                        // --- GST type radio buttons ---
                        document.querySelectorAll('input[name="gst_type_toggle"]').forEach(function(radio) {
                            radio.addEventListener('change', function () {
                                applyGstMode(this.value);
                            });
                        });

                        // --- Quick rate buttons ---
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
                                    // switch automatically to intra on rate select
                                    gstIntraRadio.checked = true;
                                    applyGstMode('intra');
                                    const half = rate / 2;
                                    cgstRateInput.value = half.toFixed(2);
                                    sgstRateInput.value = half.toFixed(2);
                                }

                                // Highlight selected button
                                document.querySelectorAll('.quick-rate-btn').forEach(b => b.classList.remove('active', 'btn-primary'));
                                this.classList.add('active', 'btn-primary');
                                this.classList.remove('btn-outline-primary');

                                calculateGST();
                            });
                        });

                        // Custom rate button re-enables manual typing
                        document.getElementById('custom_rate_btn').addEventListener('click', function () {
                            document.querySelectorAll('.quick-rate-btn').forEach(b => {
                                b.classList.remove('active', 'btn-primary');
                                b.classList.add('btn-outline-primary');
                            });
                        });

                        // --- Listen to rate input changes ---
                        [amountInput, cgstRateInput, sgstRateInput, igstRateInput].forEach(function(el) {
                            el.addEventListener('input', calculateGST);
                        });

                        // Init with No GST mode
                        applyGstMode('none');
                    </script>
                    @endpush
                </form>
            </div>
        </div>
    </div>

    {{-- Info Card (right sidebar) --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-dark text-white animate__animated animate__fadeInRight">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase mb-3" style="letter-spacing:1px; font-size:0.75rem;">
                    <i class="fas fa-info-circle me-2 text-primary"></i>GST Logic (India)
                </h6>
                <ul class="list-unstyled small text-white text-opacity-75 mb-0" style="line-height:2;">
                    <li><span class="badge bg-success me-2">INTRA</span> Student & Institute — Same State → <strong>CGST + SGST</strong></li>
                    <li><span class="badge bg-warning text-dark me-2">INTER</span> Student & Institute — Diff. State → <strong>IGST</strong></li>
                    <li class="mt-2"><i class="fas fa-bolt me-2 text-warning"></i>Auto-detected when you select the student</li>
                    <li><i class="fas fa-edit me-2 text-info"></i>You can override with the toggle above</li>
                </ul>

                <hr class="border-secondary my-3">
                <h6 class="fw-bold text-uppercase mb-2" style="letter-spacing:1px; font-size:0.75rem;">
                    <i class="fas fa-percentage me-2 text-primary"></i>Standard GST Slabs
                </h6>
                <div class="row g-2">
                    @foreach([['5%','Essential'], ['12%','Standard'], ['18%','Common'], ['28%','Luxury']] as [$slab, $desc])
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-2 text-center">
                            <div class="fw-bold">{{ $slab }}</div>
                            <div class="small text-white text-opacity-50">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <hr class="border-secondary my-3">
                <div class="small text-white text-opacity-50">
                    <i class="fas fa-university me-2"></i>
                    <strong>Institute State:</strong>
                    {{ $instituteState ?: '<span class="text-warning">Not Set — Configure in Profile</span>' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
