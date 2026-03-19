@extends('layouts.teacher')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">Enter Marks: {{ $exam->name }}</h2>
    <p class="text-muted">Batch: <span class="fw-bold text-primary">{{ $batch->name }}</span> | Date: {{ date('d M, Y', strtotime($exam->date)) }}</p>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('teacher.marks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-secondary small text-uppercase fw-bold">
                            <th width="80">#</th>
                            <th>Student Name</th>
                            <th width="200" class="text-center">Marks Obtained / 100</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td class="text-secondary">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-soft-primary rounded-circle text-primary me-2 overflow-hidden shadow-none" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(79, 70, 229, 0.2);">
                                        @if($student->profile_image)
                                            <img src="{{ asset($student->profile_image) }}" alt="{{ $student->name }}" class="img-fluid h-100 w-100 object-fit-cover">
                                        @else
                                            <i class="fas fa-user-graduate"></i>
                                        @endif
                                    </div>
                                    <span class="fw-bold text-dark">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td>
                                <input type="number" 
                                       name="marks[{{ $student->id }}]" 
                                       class="form-control form-control-lg border-0 bg-light text-center rounded-4 fw-bold text-primary shadow-none" 
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
                <a href="{{ route('teacher.marks.index', ['exam_id' => $exam->id, 'batch_id' => $batch->id]) }}" class="btn btn-light px-4 py-2 rounded-pill fw-bold border">Cancel</a>
                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-lg">
                    <i class="fas fa-save me-2"></i> Save Marks
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
