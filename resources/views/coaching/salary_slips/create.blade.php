@extends('layouts.coaching')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800 fw-bold">Generate Salary Slip</h2>
            <p class="text-muted mb-0">Create a new salary record for a teacher.</p>
        </div>
        <a href="{{ route('coaching.salary-slips.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Back to Slips
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('coaching.salary-slips.store') }}" method="POST">
                        @csrf
                        
                        <!-- Teacher Details -->
                        <h5 class="mb-4 text-primary fw-bold border-bottom pb-2">1. Employee Details</h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="teacher_id" class="form-label fw-bold">Select Teacher</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-chalkboard-teacher text-muted"></i></span>
                                    <select name="teacher_id" id="teacher_id" class="form-select border-start-0 employee-select">
                                        <option value="" selected>Choose a teacher...</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('teacher_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="faculty_id" class="form-label fw-bold">Select Faculty</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-tie text-muted"></i></span>
                                    <select name="faculty_id" id="faculty_id" class="form-select border-start-0 employee-select">
                                        <option value="" selected>Choose a faculty member...</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->name }} ({{ $faculty->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('faculty_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="alert alert-info border-0 rounded-4 py-2 small mb-4">
                            <i class="fas fa-info-circle me-2"></i> Please select either a Teacher <strong>or</strong> a Faculty member to generate the slip.
                        </div>

                        <!-- Salary Details -->
                        <h5 class="mb-4 text-primary fw-bold border-bottom pb-2 mt-5">2. Salary Structure</h5>
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <label for="month" class="form-label fw-bold">Salary Month <span class="text-danger">*</span></label>
                                <select name="month" id="month" class="form-select" required>
                                    @php
                                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                        $currentMonth = date('F');
                                    @endphp
                                    @foreach($months as $m)
                                        <option value="{{ $m }}" {{ $currentMonth === $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="year" class="form-label fw-bold">Salary Year <span class="text-danger">*</span></label>
                                <select name="year" id="year" class="form-select" required>
                                    @php $currentYear = date('Y'); @endphp
                                    @for($y = $currentYear - 2; $y <= $currentYear + 2; $y++)
                                        <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="total_days" class="form-label fw-bold">Total Days</label>
                                <input type="number" name="total_days" id="total_days" class="form-control salary-day-calc" placeholder="0">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="per_day_pay" class="form-label fw-bold">Per Day Pay (₹)</label>
                                <input type="number" step="0.01" name="per_day_pay" id="per_day_pay" class="form-control salary-day-calc" placeholder="0.00">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="basic_salary" class="form-label fw-bold">Basic Salary (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-rupee-sign text-muted"></i></span>
                                    <input type="number" step="0.01" min="0" name="basic_salary" id="basic_salary" class="form-control border-start-0 salary-calc" placeholder="0.00" required>
                                </div>
                                @error('basic_salary')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Earnings & Deductions -->
                        <div class="row mb-4">
                            <!-- Earnings -->
                            <div class="col-md-6 mb-4">
                                <div class="card bg-info bg-opacity-10 border-info border-opacity-25 h-100">
                                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold text-info mb-0"><i class="fas fa-plus-circle me-2"></i> Allowances & Earnings</h6>
                                        <button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3" onclick="addEarningRow()">Add Row</button>
                                    </div>
                                    <div class="card-body" id="earningsContainer">
                                        <!-- Dynamic Earnings -->
                                        <div class="row align-items-center mb-2 earning-row">
                                            <div class="col-6">
                                                <input type="text" name="earnings[names][]" class="form-control form-control-sm" placeholder="E.g. Transport Allowance">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="number" step="0.01" min="0" name="earnings[amounts][]" class="form-control form-control-sm salary-calc" placeholder="0.00">
                                                </div>
                                            </div>
                                            <div class="col-1 text-end">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0 pb-3">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Earnings:</span>
                                            <span class="text-info" id="totalEarningsDisp">₹0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Deductions -->
                            <div class="col-md-6 mb-4">
                                <div class="card bg-danger bg-opacity-10 border-danger border-opacity-25 h-100">
                                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold text-danger mb-0"><i class="fas fa-minus-circle me-2"></i> Deductions</h6>
                                        <button type="button" class="btn btn-sm btn-danger text-white rounded-pill px-3" onclick="addDeductionRow()">Add Row</button>
                                    </div>
                                    <div class="card-body" id="deductionsContainer">
                                        <!-- Dynamic Deductions -->
                                        <div class="row align-items-center mb-2 deduction-row">
                                            <div class="col-6">
                                                <input type="text" name="deductions[names][]" class="form-control form-control-sm" placeholder="E.g. Leave Deduction">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">₹</span>
                                                    <input type="number" step="0.01" min="0" name="deductions[amounts][]" class="form-control form-control-sm salary-calc" placeholder="0.00">
                                                </div>
                                            </div>
                                            <div class="col-1 text-end">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0 pb-3">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total Deductions:</span>
                                            <span class="text-danger" id="totalDeductionsDisp">₹0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary & Payment -->
                        <h5 class="mb-4 text-primary fw-bold border-bottom pb-2 mt-4">3. Summary & Payment</h5>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_date" class="form-label fw-bold">Payment Date <span class="text-danger">*</span></label>
                                        <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="payment_status" class="form-label fw-bold">Payment Status <span class="text-danger">*</span></label>
                                        <select name="payment_status" id="payment_status" class="form-select" required>
                                            <option value="Paid">Paid</option>
                                            <option value="Pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="remarks" class="form-label fw-bold">Remarks (Optional)</label>
                                        <textarea name="remarks" id="remarks" rows="2" class="form-control" placeholder="Any notes regarding this payment..."></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Net Salary Highlight -->
                            <div class="col-md-5 ps-md-5">
                                <div class="card bg-primary text-white border-0 shadow-lg rounded-4 overflow-hidden">
                                    <div class="card-body p-4 text-center position-relative">
                                        <!-- Background graphic -->
                                        <i class="fas fa-wallet fa-4x position-absolute opacity-25" style="top: -10px; right: -10px; transform: rotate(-15deg);"></i>
                                        
                                        <h6 class="text-uppercase mb-2 text-white-50 fw-bold letter-spacing-1">Net Salary To Pay</h6>
                                        <h2 class="display-4 fw-bold mb-0" id="netSalaryDisp">₹0.00</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5">
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light rounded-pill px-4 me-3">Reset Form</button>
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                                <i class="fas fa-save me-2"></i> Generate Salary Slip
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addEarningRow() {
        const html = `
        <div class="row align-items-center mb-2 earning-row animate__animated animate__fadeIn">
            <div class="col-6">
                <input type="text" name="earnings[names][]" class="form-control form-control-sm" placeholder="E.g. Transport Allowance" required>
            </div>
            <div class="col-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text">₹</span>
                    <input type="number" step="0.01" min="0" name="earnings[amounts][]" class="form-control form-control-sm salary-calc" placeholder="0.00" required>
                </div>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
            </div>
        </div>`;
        $('#earningsContainer').append(html);
        bindCalc();
    }

    function addDeductionRow() {
        const html = `
        <div class="row align-items-center mb-2 deduction-row animate__animated animate__fadeIn">
            <div class="col-6">
                <input type="text" name="deductions[names][]" class="form-control form-control-sm" placeholder="E.g. Leave Deduction" required>
            </div>
            <div class="col-5">
                <div class="input-group input-group-sm">
                    <span class="input-group-text">₹</span>
                    <input type="number" step="0.01" min="0" name="deductions[amounts][]" class="form-control form-control-sm salary-calc" placeholder="0.00" required>
                </div>
            </div>
            <div class="col-1 text-end">
                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
            </div>
        </div>`;
        $('#deductionsContainer').append(html);
        bindCalc();
    }

    function removeRow(btn) {
        $(btn).closest('.row').remove();
        calculateSalary();
    }

    function calculateSalary() {
        let totalDays = parseFloat($('#total_days').val()) || 0;
        let perDayPay = parseFloat($('#per_day_pay').val()) || 0;
        
        if (totalDays > 0 && perDayPay > 0) {
            let calculatedBasic = totalDays * perDayPay;
            $('#basic_salary').val(calculatedBasic.toFixed(2));
        }

        let basic = parseFloat($('#basic_salary').val()) || 0;
        
        let totalEarnings = 0;
        $('input[name^="earnings[amounts]"]').each(function() {
            totalEarnings += parseFloat($(this).val()) || 0;
        });
        $('#totalEarningsDisp').text('₹' + totalEarnings.toFixed(2));

        let totalDeductions = 0;
        $('input[name^="deductions[amounts]"]').each(function() {
            totalDeductions += parseFloat($(this).val()) || 0;
        });
        $('#totalDeductionsDisp').text('₹' + totalDeductions.toFixed(2));

        let net = basic + totalEarnings - totalDeductions;
        $('#netSalaryDisp').text('₹' + net.toFixed(2));
    }

    function fetchAttendanceCount() {
        const teacherId = $('#teacher_id').val();
        const facultyId = $('#faculty_id').val();
        const month = $('#month').val();
        const year = $('#year').val();

        if ((teacherId || facultyId) && month && year) {
            $.ajax({
                url: "{{ route('coaching.salary-slips.attendance-count') }}",
                type: "GET",
                data: {
                    teacher_id: teacherId,
                    faculty_id: facultyId,
                    month: month,
                    year: year
                },
                success: function(response) {
                    if (response.count !== undefined) {
                        $('#total_days').val(response.count);
                        calculateSalary();
                    }
                },
                error: function(xhr) {
                    console.error('Error fetching attendance count:', xhr.responseText);
                }
            });
        }
    }

    function bindCalc() {
        $('.salary-calc, .salary-day-calc').off('input').on('input', calculateSalary);
        
        $('.employee-select').on('change', function() {
            const currentId = $(this).attr('id');
            if ($(this).val()) {
                // Clear the other select
                $('.employee-select').not(this).val('');
            }
            fetchAttendanceCount();
        });
        
        $('#month, #year').on('change', fetchAttendanceCount);
    }

    $(document).ready(function() {
        bindCalc();
        // Initial fetch if values are pre-filled
        fetchAttendanceCount();
    });
</script>
@endpush
