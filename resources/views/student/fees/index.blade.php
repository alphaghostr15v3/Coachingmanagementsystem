@extends('layouts.student')

@section('content')
<div class="mb-4 animate__animated animate__fadeIn">
    <h2 class="fw-bold">My Fee Payment History</h2>
    <p class="text-muted">Track all your payments and pending dues.</p>
</div>

<div class="card border-0 shadow-sm animate__animated animate__fadeInUp">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-secondary small text-uppercase">
                        <th>Date</th>
                        <th>Amount</th>
                        <th class="text-center">Status</th>
                        <th>Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Assuming we find fees by student email/id --}}
                    @php
                        $user = auth()->user();
                        $student = \App\Models\Student::where('email', $user->email)->first();
                        $fees = $student ? \App\Models\Fee::where('student_id', $student->id)->latest()->get() : [];
                    @endphp
                    @forelse($fees as $fee)
                    <tr>
                        <td class="fw-bold">{{ date('d M, Y', strtotime($fee->created_at)) }}</td>
                        <td class="text-primary fw-bold">₹{{ number_format($fee->amount, 2) }}</td>
                        <td class="text-center">
                            <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill">Paid</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill fw-bold">
                                <i class="fas fa-download me-1"></i> PDF
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">No fee records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
</style>
@endsection
