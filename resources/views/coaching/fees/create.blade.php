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
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="student_id" class="form-label fw-bold small text-uppercase text-secondary">Student <span class="text-danger">*</span></label>
                            <select name="student_id" id="student_id" class="form-select form-select-lg border-0 bg-light rounded-4 @error('student_id') is-invalid @enderror" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
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

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label for="amount" class="form-label fw-bold small text-uppercase text-secondary">Amount Received (₹) <span class="text-danger">*</span></label>
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
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending/Partial</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('coaching.fees.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Cancel</a>
                        <button type="submit" class="btn btn-success px-5 py-2 rounded-4 fw-bold shadow text-white">
                            <i class="fas fa-check-circle me-2"></i> Submit Payment Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
