@extends('layouts.student')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">Announcements</h2>
    <p class="text-muted small">Important updates and news from your coaching center.</p>
</div>

<div class="row g-4 animate__animated animate__fadeInUp">
    @forelse($notices as $notice)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 p-4">
            <div class="bg-soft-warning p-3 rounded-4 text-warning d-inline-block mb-3" style="width: fit-content;">
                <i class="fas fa-bullhorn fs-4"></i>
            </div>
            <h5 class="fw-bold mb-2">{{ $notice->title }}</h5>
            <p class="text-muted small mb-3">{{ $notice->description }}</p>
            <div class="mt-auto pt-3 border-top text-secondary smaller">
                Posted {{ $notice->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h5 class="text-muted">No announcements posted yet.</h5>
    </div>
    @endforelse
</div>

<style>
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
</style>
@endsection
