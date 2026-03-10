@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.notices.index') }}" class="text-decoration-none">Notice Board</a></li>
            <li class="breadcrumb-item active">Post Notice</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Create New Announcement</h2>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('coaching.notices.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold small text-uppercase text-secondary">Notice Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg border-0 bg-light rounded-4 @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Schedule Change, Holiday Announcement">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="form-label fw-bold small text-uppercase text-secondary">Announcement Content <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="5" class="form-control border-0 bg-light rounded-4 @error('description') is-invalid @enderror" required placeholder="Describe the announcement in detail...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('coaching.notices.index') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                            <i class="fas fa-paper-plane me-2"></i> Post Notice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
