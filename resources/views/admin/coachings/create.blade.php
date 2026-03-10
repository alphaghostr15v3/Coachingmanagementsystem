@extends('layouts.admin')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-indigo">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.coachings.index') }}" class="text-decoration-none text-indigo">Coachings</a></li>
            <li class="breadcrumb-item active">New Registration</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Register New Institute</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.coachings.store') }}" method="POST">
                    @csrf
                    <h5 class="fw-bold mb-4 text-indigo"><i class="fas fa-university me-2"></i> Institute Information</h5>
                    
                    <div class="mb-4">
                        <label for="coaching_name" class="form-label fw-bold small text-uppercase text-secondary">Coaching Institute Name <span class="text-danger">*</span></label>
                        <input type="text" name="coaching_name" id="coaching_name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('coaching_name') is-invalid @enderror" value="{{ old('coaching_name') }}" required placeholder="e.g. Apex Academy">
                        @error('coaching_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="owner_name" class="form-label fw-bold small text-uppercase text-secondary">Owner/Administrator Name <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name" id="owner_name" class="form-control form-control-lg border-0 bg-light rounded-4 @error('owner_name') is-invalid @enderror" value="{{ old('owner_name') }}" required placeholder="John Doe">
                            @error('owner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold small text-uppercase text-secondary">Admin Login Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg border-0 bg-light rounded-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="admin@apexacademy.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <label for="mobile" class="form-label fw-bold small text-uppercase text-secondary">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" id="mobile" class="form-control form-control-lg border-0 bg-light rounded-4 @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" required placeholder="10-digit mobile number">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label fw-bold small text-uppercase text-secondary">Institute State <span class="text-danger">*</span></label>
                            <select name="state" id="state" class="form-select form-select-lg border-0 bg-light rounded-4 @error('state') is-invalid @enderror" required>
                                <option value="">Select State</option>
                                @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir','Ladakh','Lakshadweep','Puducherry'] as $st)
                                    <option value="{{ $st }}" {{ old('state') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="gst_number" class="form-label fw-bold small text-uppercase text-secondary">GST Registration Number</label>
                            <input type="text" name="gst_number" id="gst_number" class="form-control form-control-lg border-0 bg-light rounded-4 @error('gst_number') is-invalid @enderror" value="{{ old('gst_number') }}" placeholder="e.g. 27AAAAA0000A1Z5">
                            @error('gst_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="password" class="form-label fw-bold small text-uppercase text-secondary">Admin Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg border-0 bg-light rounded-4 @error('password') is-invalid @enderror" required placeholder="Minimum 8 characters">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="subscription_plan" class="form-label fw-bold small text-uppercase text-secondary">Subscription Tier <span class="text-danger">*</span></label>
                        <select name="subscription_plan" id="subscription_plan" class="form-select form-select-lg border-0 bg-light rounded-4 @error('subscription_plan') is-invalid @enderror" required>
                            <option value="starter" {{ old('subscription_plan') == 'starter' ? 'selected' : '' }}>Starter Plan (Free)</option>
                            <option value="pro" {{ old('subscription_plan') == 'pro' ? 'selected' : '' }}>Institutional Pro (Paid)</option>
                            <option value="enterprise" {{ old('subscription_plan') == 'enterprise' ? 'selected' : '' }}>Enterprise Edge (Full-scale)</option>
                        </select>
                        @error('subscription_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('admin.coachings.index') }}" class="btn btn-light px-4 py-3 rounded-4 fw-bold border-0 shadow-sm text-secondary">Cancel</a>
                        <button type="submit" class="btn btn-gradient px-5 py-3 rounded-4 fw-bold shadow-lg">
                            <i class="fas fa-magic me-2"></i> Deploy & Migrate Database
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-indigo text-white animate__animated animate__fadeInRight">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-server me-2"></i> Deployment Info</h5>
                <div class="mb-4">
                    <p class="small opacity-75 mb-2">Automated Provisioning Process:</p>
                    <ul class="small ps-3 opacity-75">
                        <li class="mb-2">Unique tenant database creation.</li>
                        <li class="mb-2">Execution of 9+ isolated table migrations.</li>
                        <li class="mb-2">Super Admin password setup notification.</li>
                    </ul>
                </div>
                <div class="alert bg-white bg-opacity-10 border-0 text-white rounded-4 small">
                    <i class="fas fa-info-circle me-2"></i> The administrator will receive an email to set their login password once the database is live.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-indigo { color: #4f46e5; }
    .bg-indigo { background: #1e1b4b; }
    .form-control:focus, .form-select:focus {
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
</style>
@endsection
