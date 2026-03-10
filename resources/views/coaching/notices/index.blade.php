@extends('layouts.coaching')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
    <div>
        <h2 class="fw-bold mb-1">Notice Board</h2>
        <p class="text-muted small">Post announcements for all students and teachers.</p>
    </div>
    <a href="{{ route('coaching.notices.create') }}" class="btn btn-primary px-4">
        <i class="fas fa-plus me-2"></i> Post New Notice
    </a>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    @forelse($notices as $notice)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-gradient-warning p-2 rounded-3 text-white shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link link-secondary p-0" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                            <li><a class="dropdown-item" href="{{ route('coaching.notices.edit', $notice) }}"><i class="fas fa-edit me-2"></i> Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('coaching.notices.destroy', $notice) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i> Remove</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">{{ $notice->title }}</h5>
                <p class="text-muted small mb-4 line-clamp-3">{{ $notice->description }}</p>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                    <span class="text-secondary small">
                        <i class="far fa-clock me-1"></i> {{ $notice->created_at->diffForHumans() }}
                    </span>
                    <span class="badge bg-soft-info text-info">General</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
            <i class="fas fa-bullhorn fs-1 text-muted"></i>
        </div>
        <h5 class="text-muted">No notices posted yet.</h5>
    </div>
    @endforelse
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .bg-soft-info { background: rgba(59, 130, 246, 0.1); }
</style>
@endsection
