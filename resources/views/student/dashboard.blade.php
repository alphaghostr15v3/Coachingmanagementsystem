@extends('layouts.student')

@section('content')
<div class="row g-4 animate__animated animate__fadeIn">
    <div class="col-12">
        <div class="card border-0 bg-info text-white p-4 shadow-lg rounded-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%) !important;">
            <div class="position-relative z-index-1">
                <h2 class="fw-bold mb-1">Hello, {{ $student->name ?? auth()->user()->name }}!</h2>
                <p class="opacity-75 mb-0">Track your progress and stay updated with your coaching.</p>
            </div>
            <i class="fas fa-user-graduate position-absolute end-0 bottom-0 opacity-25 m-n3" style="font-size: 150px;"></i>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm p-4 h-100 animate__animated animate__zoomIn" style="animation-delay: 0.1s">
            <h6 class="text-secondary small fw-bold text-uppercase mb-3">Attendance</h6>
            <div class="d-flex align-items-center">
                <div class="bg-soft-info p-3 rounded-4 text-info me-3">
                    <i class="fas fa-calendar-check fs-4"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-nowrap">{{ $totalPresentDays }}</h3>
                    <p class="text-muted small mb-0">Total Days</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm p-4 h-100 animate__animated animate__zoomIn" style="animation-delay: 0.2s">
            <h6 class="text-secondary small fw-bold text-uppercase mb-3">Recent Result</h6>
            <div class="d-flex align-items-center">
                @if($marks->count() > 0)
                    @php $latestMark = $marks->first(); @endphp
                    <div class="bg-soft-{{ $latestMark->grade_color }} p-3 rounded-4 text-{{ $latestMark->grade_color }} me-3">
                        <i class="fas fa-poll fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $latestMark->grade }}</h3>
                        <p class="text-muted small mb-0">{{ $latestMark->exam->name ?? 'Recent Exam' }}</p>
                    </div>
                @else
                    <div class="bg-soft-secondary p-3 rounded-4 text-secondary me-3">
                        <i class="fas fa-poll fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">N/A</h3>
                        <p class="text-muted small mb-0">No Result</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between">
                <h5 class="fw-bold m-0">Recent Notices</h5>
                <a href="{{ route('student.notices') }}" class="small text-decoration-none">View All</a>
            </div>
            <div class="card-body p-4">
                @foreach($notices as $notice)
                <div class="d-flex mb-3 pb-3 border-bottom last-child-no-border">
                    <div class="bg-light p-2 rounded-3 text-warning me-3 h-100">
                        <i class="fas fa-bullhorn small"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 small">{{ $notice->title }}</h6>
                        <span class="text-muted smaller">{{ $notice->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="fw-bold m-0">Academic Performance</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-secondary small text-uppercase">
                                <th>Exam Name</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Marks Obtained</th>
                                <th class="text-center">Grade</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($marks as $mark)
                            <tr>
                                <td class="fw-bold">{{ $mark->exam->name ?? 'Exam' }}</td>
                                <td class="text-center small">{{ date('d M, Y', strtotime($mark->exam->date)) }}</td>
                                <td class="text-center"><span class="badge bg-soft-primary text-primary fs-6">{{ $mark->marks_obtained }}</span></td>
                                <td class="text-center"><span class="badge bg-{{ $mark->grade_color }} fs-6">{{ $mark->grade }}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold">Details</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted small">No exam results available yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-primary { background: rgba(79, 70, 229, 0.1); }
    .last-child-no-border:last-child { border-bottom: 0 !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }
</style>
@endsection
