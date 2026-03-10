@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">Institute Notice Board</h2>
    <p class="text-muted small">Stay updated with the latest announcements from the management.</p>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    @forelse($notices as $notice)
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-soft-warning p-3 rounded-4 text-warning me-3">
                    <i class="fas fa-bullhorn fs-4"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">{{ $notice->title }}</h5>
                    <span class="text-secondary smaller">{{ $notice->created_at->format('d M, Y') }}</span>
                </div>
            </div>
            <p class="text-muted small mb-0">{{ $notice->description }}</p>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h5 class="text-muted">No notices at the moment.</h5>
    </div>
    @endforelse
</div>

<style>
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
</style>
@endsection
