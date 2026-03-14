@extends('layouts.coaching')

@section('content')
<div class="container-fluid">
    <div class="row animate__animated animate__fadeIn">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-0">Institute Settings</h3>
                    <p class="text-muted">Manage your coaching center's identity and documentation details.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0 fw-bold"><i class="fas fa-university me-2 text-primary"></i> Institute Information</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('coaching.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Coaching Name</label>
                                <input type="text" name="coaching_name" class="form-control rounded-3" value="{{ old('coaching_name', $currentCoaching->coaching_name) }}" required>
                                @error('coaching_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Institute State (for GST)</label>
                                <select name="state" class="form-select rounded-3" required>
                                    <option value="">Select State</option>
                                    @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli and Daman and Diu','Delhi','Jammu and Kashmir','Ladakh','Lakshadweep','Puducherry'] as $st)
                                        <option value="{{ $st }}" {{ old('state', $currentCoaching->state) == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                                @error('state') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" class="form-control rounded-3" rows="2">{{ old('address', $currentCoaching->address) }}</textarea>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">GST Number</label>
                                <input type="text" name="gst_number" class="form-control rounded-3" value="{{ old('gst_number', $currentCoaching->gst_number) }}" placeholder="Optional">
                                @error('gst_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Authorized Signatory Name</label>
                                <input type="text" name="authorized_signatory" class="form-control rounded-3" value="{{ old('authorized_signatory', $currentCoaching->authorized_signatory) }}" placeholder="e.g. Director Name">
                                @error('authorized_signatory') <small class="text-danger">{{ $message }}</small> @enderror
                                <p class="text-xs text-muted mt-1">This name will appear on salary slips and invoices.</p>
                            </div>

                            <div class="col-12 mt-5 py-4 border-top">
                                <h5 class="fw-bold mb-3"><i class="fas fa-signature me-2 text-primary"></i> Digital Signature Image</h5>
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center mb-3 mb-md-0">
                                        <div class="bg-light p-3 rounded-4 border d-inline-block shadow-sm">
                                            @if($currentCoaching->signatory_image)
                                                <img src="{{ asset('uploads/signatories/' . $currentCoaching->signatory_image) }}" alt="Current Signature" class="img-fluid rounded" style="max-height: 100px;">
                                                <p class="text-xs mt-2 mb-0">Current Signature</p>
                                            @else
                                                <div class="text-muted p-4">
                                                    <i class="fas fa-image fa-3x mb-2 opacity-25"></i>
                                                    <p class="small mb-0">No Signature Uploaded</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="btn btn-outline-primary btn-sm mb-2">
                                            <i class="fas fa-upload me-2"></i> Choose New Signature
                                            <input type="file" name="signatory_image" class="d-none" accept="image/*">
                                        </label>
                                        <p class="text-muted small mb-0">Recommended: Transparent PNG or high-quality JPG. Max 2MB.</p>
                                        <div id="file-name-display" class="small text-primary mt-1 fw-medium"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm rounded-3">
                                    <i class="fas fa-save me-2"></i> Update Settings
                                </button>
                            </div>
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
    document.querySelector('input[name="signatory_image"]').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '';
        document.getElementById('file-name-display').textContent = fileName ? 'Selected: ' + fileName : '';
    });
</script>
@endpush
