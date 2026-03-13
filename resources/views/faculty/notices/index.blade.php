@extends('layouts.faculty')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('faculty.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active">Notices</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold m-0 text-dark">Institute Notice Board</h2>
            <p class="text-muted small mb-0">Stay updated with the latest announcements from the management.</p>
        </div>
    </div>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    @forelse($notices as $notice)
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 p-4 rounded-4 transition">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-warning-soft p-3 rounded-circle text-warning me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fas fa-bullhorn fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">{{ $notice->title }}</h5>
                    <span class="text-secondary smaller"><i class="far fa-clock me-1"></i> {{ $notice->created_at->format('d M, Y') }}</span>
                </div>
            </div>
            <p class="text-muted small mb-0">{{ $notice->description }}</p>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="opacity-50 mb-3">
                <i class="fas fa-bell-slash fa-3x text-muted"></i>
            </div>
            <h5 class="text-muted mb-0">No notices at the moment.</h5>
        </div>
    </div>
    @endforelse
</div>

<style>
    .bg-warning-soft { background: rgba(245, 158, 11, 0.1); }
    .transition { transition: all 0.3s ease; }
    .transition:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
</style>
@endsection
