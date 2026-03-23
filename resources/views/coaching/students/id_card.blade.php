@extends('layouts.coaching')

@section('content')
<div class="container py-5 animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-5 no-print">
        <div>
            <h2 class="fw-bold mb-1">Student ID Card</h2>
            <p class="text-muted small">Professional identification card for {{ $student->name }}.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('coaching.students.index') }}" class="btn btn-outline-secondary shadow-sm px-4">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
            <button onclick="window.print()" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-print me-2"></i> Print ID Card
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <!-- Professional ID Card -->
            <div class="id-card-wrapper position-relative">
                <div class="id-card-main shadow-lg overflow-hidden border">
                    <!-- Top Ribbon / Branding -->
                    <div class="id-card-header d-flex align-items-center p-3 text-white">
                        <div class="id-logo-container bg-white rounded-circle p-1 me-3 shadow-sm">
                            @if($coaching && $coaching->profile_image)
                                <img src="{{ asset($coaching->profile_image) }}" alt="Logo" class="id-logo">
                            @else
                                <div class="id-logo-placeholder text-primary fw-bold">
                                    {{ substr($coaching->coaching_name ?? 'C', 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="id-institute-info">
                            <h5 class="mb-0 fw-bold">{{ $coaching->coaching_name ?? 'COACHING INSTITUTE' }}</h5>
                            <p class="mb-0 x-small text-white-50 opacity-75">Quality Education For Brighter Future</p>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="id-card-body p-4 position-relative">
                        <!-- Watermark -->
                        <div class="id-watermark">STUDENT</div>

                        <!-- Photo Section -->
                        <div class="id-photo-section text-center mb-3">
                            <div class="id-photo-frame mx-auto shadow-sm">
                                @if($student->profile_image)
                                    <img src="{{ asset($student->profile_image) }}" alt="{{ $student->name }}" class="id-photo">
                                @else
                                    <div class="id-photo-placeholder bg-light text-muted h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user fa-3x"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Student Basic Info -->
                        <div class="text-center mb-3">
                            <h4 class="student-display-name fw-bold text-dark mb-1">{{ strtoupper($student->name) }}</h4>
                            <div class="id-tag rounded-pill px-3 py-1 bg-soft-primary text-primary d-inline-block x-small fw-bold">STUDENT</div>
                        </div>

                        <!-- Formal Details -->
                        <div class="id-details-grid bg-light rounded-3 p-3">
                            <div class="row gx-1 mb-2 border-bottom pb-1">
                                <div class="col-5 text-muted x-small fw-bold uppercase">Enrollment No</div>
                                <div class="col-7 text-dark fw-bold small">STU-{{ str_pad($student->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <div class="row gx-1 mb-2 border-bottom pb-1">
                                <div class="col-5 text-muted x-small fw-bold uppercase">Course Name</div>
                                <div class="col-7 text-dark fw-bold small text-truncate">{{ $student->course->name ?? 'GENERAL' }}</div>
                            </div>
                            <div class="row gx-1 mb-2 border-bottom pb-1">
                                <div class="col-5 text-muted x-small fw-bold uppercase">Batch / Timing</div>
                                <div class="col-7 text-dark fw-bold small">
                                    @php $batch = $student->batches->first(); @endphp
                                    <span class="text-truncate d-block">{{ $batch->name ?? 'Regular' }}</span>
                                    <span class="x-small text-muted">
                                        @if($batch && $batch->start_time && $batch->end_time)
                                            {{ \Carbon\Carbon::parse($batch->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($batch->end_time)->format('h:i A') }}
                                        @else
                                            {{ $batch->class_time ?? 'N/A' }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="row gx-1 mb-0">
                                <div class="col-5 text-muted x-small fw-bold uppercase">Mobile No</div>
                                <div class="col-7 text-dark fw-bold small">+91 {{ $student->phone ?? 'XXXXXXXXXX' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="id-card-footer px-3 py-3 text-center text-white">
                        <div class="x-small uppercase mb-1 opacity-75 fw-bold">Contact Institute</div>
                        <div class="small fw-bold"><i class="fas fa-phone-alt me-2 text-warning"></i> {{ $coaching->mobile ?? '+91 XXXXX XXXXX' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f1f5f9;
    }

    .x-small { font-size: 0.65rem; }
    .uppercase { text-transform: uppercase; letter-spacing: 0.5px; }
    .bg-soft-primary { background-color: rgba(37, 99, 235, 0.1); }

    .id-card-main {
        width: 380px;
        min-height: 600px; /* Slightly taller to ensure no overlap */
        background: #fff;
        border-radius: 20px;
        margin: 0 auto;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .id-card-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        border-radius: 0;
        min-height: 100px;
    }

    .id-logo-container {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .id-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .id-photo-frame {
        width: 140px;
        height: 170px;
        border: 5px solid #fff;
        border-radius: 15px;
        overflow: hidden;
        background: #f8fafc;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        position: relative;
        z-index: 2;
    }

    .id-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-display-name {
        letter-spacing: -0.5px;
        color: #111827;
        font-size: 1.5rem;
    }

    .id-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-30deg);
        font-size: 4.5rem;
        font-weight: 900;
        color: rgba(0,0,0,0.015); /* Extremely subtle */
        white-space: nowrap;
        pointer-events: none;
        z-index: 0;
        letter-spacing: 5px;
    }

    .id-card-body {
        flex-grow: 1;
        z-index: 1;
        padding-bottom: 80px !important; /* Space for absolute footer */
    }

    .id-card-footer {
        background: #0f172a;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        border-top: 2px solid #2563eb;
    }

    .id-details-grid .row {
        align-items: center;
    }

    @media print {
        .sidebar, .topbar, footer, .no-print { display: none !important; }
        .main-wrapper { margin: 0 !important; padding: 0 !important; }
        .main-content { padding: 0 !important; margin: 0 !important; }
        body { background: white !important; }
        .container { 
            padding: 0 !important; 
            margin: 0 !important;
            max-width: none !important; 
            width: 100% !important;
        }
        .id-card-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            justify-content: center !important;
        }
        .id-card-main {
            box-shadow: none !important;
            border: 1px solid #eee !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            margin-top: 0 !important;
        }
        .id-card-header, .id-card-footer {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
@endsection
