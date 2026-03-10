@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">Mark Attendance: {{ $batch->name }}</h2>
    <p class="text-muted">Select students to mark them present/absent for today.</p>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('teacher.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="batch_id" value="{{ $batch->id }}">
            
            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase text-secondary">Attendance Date</label>
                <input type="date" name="date" class="form-control form-control-lg border-0 bg-light rounded-4 w-auto" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-secondary small text-uppercase">
                            <th width="80">#</th>
                            <th>Student Name</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="fw-bold">{{ $student->name }}</span></td>
                            <td>
                                <div class="d-flex justify-content-center gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" id="p{{ $student->id }}" value="present" checked>
                                        <label class="form-check-label text-success fw-bold" for="p{{ $student->id }}">Present</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status[{{ $student->id }}]" id="a{{ $student->id }}" value="absent">
                                        <label class="form-check-label text-danger fw-bold" for="a{{ $student->id }}">Absent</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                <a href="{{ route('teacher.batches') }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Back</a>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                    <i class="fas fa-check-double me-2"></i> Submit Attendance
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
