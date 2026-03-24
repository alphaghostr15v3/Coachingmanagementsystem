@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.attendance.index') }}" class="text-decoration-none">Attendance</a></li>
            <li class="breadcrumb-item active">Mark Daily Sheet</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="fw-bold m-0">Daily Attendance Marking</h2>
        <div class="bg-white px-3 py-2 rounded-4 border shadow-sm">
            <i class="fas fa-calendar-day text-primary me-2"></i>
            <span class="fw-bold">{{ date('d M, Y') }}</span>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp mb-4">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('coaching.attendance.create') }}" method="GET">
            <div class="row align-items-end">
                <div class="col-md-5">
                    <label for="batch_id" class="form-label fw-bold small text-uppercase text-secondary">Select Batch <span class="text-danger">*</span></label>
                    <select name="batch_id" id="batch_id" class="form-select form-select-lg border-0 bg-light rounded-4" onchange="this.form.submit()" required>
                        <option value="">-- Choose Batch --</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id }}" {{ (isset($batch) && $batch->id == $b->id) ? 'selected' : '' }}>{{ $b->name }} {{ $b->course ? ' - ' . $b->course->name : '' }} {{ $b->teacher ? ' (' . $b->teacher->name . ')' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <label for="date_filter" class="form-label fw-bold small text-uppercase text-secondary">Attendance Date</label>
                    <input type="date" name="date" id="date_filter" class="form-control form-control-lg border-0 bg-light rounded-4" value="{{ $date }}" onchange="this.form.submit()">
                </div>
            </div>
        </form>
    </div>
</div>

@if(isset($batch))
<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('coaching.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="batch_id" value="{{ $batch->id }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <div class="row mb-5 align-items-end">
                <div class="col-md-12 text-md-end mt-3 mt-md-0">
                    <p class="text-muted small m-0">Tip: Select "Absent" only for students who are not present today.</p>
                </div>
            </div>

            <div class="table-responsive mb-5 px-1">
                <table class="table table-hover align-middle border-top">
                    <thead class="bg-light">
                        <tr>
                            <th width="60" class="text-secondary small text-uppercase py-3 ps-4">#</th>
                            <th class="text-secondary small text-uppercase py-3">Student Full Name</th>
                            <th class="text-center text-secondary small text-uppercase py-3 pe-4" width="250">Presence Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr class="transition">
                            <td class="text-secondary ps-4">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($student->profile_image)
                                        <img src="{{ asset($student->profile_image) }}" alt="Profile" class="rounded-circle me-3" style="width: 35px; height: 35px; object-fit: cover;">
                                    @else
                                        <div class="avatar-xs bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                    <span class="fw-bold text-dark">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group w-100 p-1 bg-light rounded-4 border" role="group">
                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="present_{{ $student->id }}" value="present" {{ ($existingAttendance->get($student->id) ?? 'present') === 'present' ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-success border-0 rounded-4 fw-bold py-2" for="present_{{ $student->id }}">
                                        <i class="fas fa-check-circle me-1"></i> PRESENT
                                    </label>

                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="absent_{{ $student->id }}" value="absent" {{ ($existingAttendance->get($student->id)) === 'absent' ? 'checked' : '' }} autocomplete="off">
                                    <label class="btn btn-outline-danger border-0 rounded-4 fw-bold py-2" for="absent_{{ $student->id }}">
                                        <i class="fas fa-times-circle me-1"></i> ABSENT
                                    </label>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash fs-1 d-block mb-3 opacity-25"></i>
                                No students found. Please <a href="{{ route('coaching.students.create') }}">register students</a> first to mark attendance.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->count() > 0)
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow-lg">
                    <i class="fas fa-save me-2"></i> Confirm & Save Attendance Sheet
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endif

<style>
    .btn-check:checked + .btn-outline-success { background-color: #10b981 !important; color: #fff !important; }
    .btn-check:checked + .btn-outline-danger { background-color: #ef4444 !important; color: #fff !important; }
    .bg-soft-primary { background: rgba(99, 102, 241, 0.1); }
    tr:hover { background-color: rgba(248, 250, 252, 0.8); }
</style>
@endsection
