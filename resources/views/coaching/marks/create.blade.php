@extends('layouts.coaching')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('coaching.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coaching.marks.index') }}" class="text-decoration-none">Marks Management</a></li>
            <li class="breadcrumb-item active">Enter Marks</li>
        </ol>
    </nav>
    <h2 class="fw-bold">Enter Marks: {{ $exam->name }}</h2>
    <p class="text-muted">Batch: {{ $batch->name }} ({{ $batch->course->name ?? '' }}) | Date: {{ date('d M, Y', strtotime($exam->date)) }}</p>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('coaching.marks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="80" class="text-secondary small text-uppercase">#</th>
                            <th class="text-secondary small text-uppercase">Student Name</th>
                            <th class="text-secondary small text-uppercase">Email</th>
                            <th width="200" class="text-center text-secondary small text-uppercase">Marks Obtained / 100</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td class="text-secondary">{{ $loop->iteration }}</td>
                            <td><span class="fw-bold">{{ $student->name }}</span></td>
                            <td class="text-muted small">{{ $student->email }}</td>
                            <td>
                                <input type="number" 
                                       name="marks[{{ $student->id }}]" 
                                       class="form-control form-control-lg border-0 bg-light text-center rounded-3 fw-bold text-primary" 
                                       placeholder="0.00" 
                                       step="0.01" 
                                       max="100" 
                                       value="{{ $existing_marks[$student->id]->marks_obtained ?? '' }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                <a href="{{ route('coaching.marks.index', ['exam_id' => $exam->id, 'batch_id' => $batch->id]) }}" class="btn btn-light px-4 py-2 rounded-4 fw-bold border">Cancel</a>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-4 fw-bold shadow">
                    <i class="fas fa-save me-2"></i> Save Marks
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
