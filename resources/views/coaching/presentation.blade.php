@extends('layouts.coaching')

@section('content')
<div class="container py-5 no-print animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-primary">Sales Presentation</h2>
            <p class="text-muted small mb-0">Navigate through the slides or print the entire presentation to PDF.</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm border-0">
            <i class="fas fa-file-pdf me-2"></i> Save as PDF
        </button>
    </div>
</div>

<!-- Presentation Slides Area -->
<div class="presentation-container pb-5">
    <!-- Slide 1: Title -->
    <div class="presentation-slide mb-5">
        <div class="slide-content card border-0 shadow-lg overflow-hidden glass-card">
            <div class="slide-header bg-gradient-primary p-5 text-center text-white position-relative">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                </div>
                <div class="avatar-lg bg-white bg-opacity-25 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="fas fa-graduation-cap fs-1"></i>
                </div>
                <h1 class="display-4 fw-bold mb-3">Coaching Management System</h1>
                <p class="lead mb-0 opacity-75">The All-in-One Digital Portal for Premium Coaching Institutes</p>
                <div class="mt-4 badge bg-white text-primary px-3 py-2 rounded-pill uppercase fw-bold" style="font-size: 0.7rem;">Product Overview 2026</div>
            </div>
            <div class="card-body p-5">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="fw-bold text-dark border-start border-4 border-primary ps-3 mb-4">Executive Summary</h3>
                        <p class="text-muted lead">Our platform is a state-of-the-art, glassmorphism-inspired administrative platform designed to streamline every aspect of coaching institute operations. From student enrollment to financial analytics, it provides a "Premium Portal" experience for modern educators.</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('assets/img/presentation-hero.svg') }}" alt="Dashboard Preview" class="img-fluid rounded-4 shadow-sm" onerror="this.src='https://img.freepik.com/free-vector/modern-data-analytics-concept_23-2148441113.jpg'">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 2: Design Philosophy -->
    <div class="presentation-slide mb-5">
        <div class="slide-content card border-0 shadow-lg overflow-hidden glass-card">
            <div class="card-body p-5">
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold text-primary mb-2">🎨 Design Philosophy</h2>
                    <div class="mx-auto bg-primary rounded-pill mb-4" style="width: 60px; height: 4px;"></div>
                    <p class="text-muted lead">A modern aesthetic that builds trust and enhances usability.</p>
                </div>
                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-light text-center transition-card">
                            <div class="icon-circle bg-primary text-white mx-auto mb-3">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h5 class="fw-bold">Glassmorphism</h5>
                            <p class="small text-muted mb-0">Transparent interfaces with blur effects for a breathable, high-end feel.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-light text-center transition-card">
                            <div class="icon-circle bg-info text-white mx-auto mb-3">
                                <i class="fas fa-wind"></i>
                            </div>
                            <h5 class="fw-bold">Micro-Animations</h5>
                            <p class="small text-muted mb-0">Subtle, dynamic movements that guide attention and improve engagement.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 bg-light text-center transition-card">
                            <div class="icon-circle bg-dark text-white mx-auto mb-3">
                                <i class="fas fa-keyboard"></i>
                            </div>
                            <h5 class="fw-bold">Modern Fonts</h5>
                            <p class="small text-muted mb-0">Clean, geometric typography using the 'Outfit' font family for professional look.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 3: Student & Identity -->
    <div class="presentation-slide mb-5">
        <div class="slide-content card border-0 shadow-lg overflow-hidden glass-card">
            <div class="row g-0 h-100">
                <div class="col-md-5 bg-dark p-5 text-white d-flex align-items-center">
                    <div>
                        <div class="mb-4">
                            <span class="badge bg-primary px-3 py-2 rounded-pill small mb-2">Student Portal</span>
                            <h2 class="display-6 fw-bold">Enrollment & Identity</h2>
                        </div>
                        <p class="opacity-75 mb-4">Empower your administrative staff and impress your students from day one.</p>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3"></i> Automated enrollment workflow</li>
                            <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3"></i> Instant Professional ID Cards</li>
                            <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3"></i> High-resolution student profiling</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7 p-5 bg-white">
                    <h4 class="fw-bold text-dark border-bottom pb-3 mb-4">Professional ID Cards</h4>
                    <div class="id-card-demo p-4 rounded-4 bg-light border border-dashed mb-4 text-center">
                        <div class="p-3 bg-white shadow-sm rounded-3 d-inline-block border">
                            <div class="text-primary fw-bold small text-uppercase mb-2">Preview Sample</div>
                            <div class="d-flex align-items-start border p-2" style="width: 320px; text-align: left;">
                                <div class="bg-light rounded me-2" style="width: 60px; height: 70px;"></div>
                                <div style="font-size: 0.6rem;">
                                    <div class="fw-bold">John Doe</div>
                                    <div>Enrollment: CMS/2026/001</div>
                                    <div>Course: Medical Foundation</div>
                                    <div>Batch: Morning [09:00 - 11:00]</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted small">Our built-in ID Card generator eliminates external design costs and waiting times, delivering professional results instantly with full institute branding.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 4: Real-time Analytics -->
    <div class="presentation-slide mb-5">
        <div class="slide-content card border-0 shadow-lg overflow-hidden glass-card">
            <div class="card-body p-5">
                <div class="row align-items-center">
                    <div class="col-md-6 order-md-2">
                        <h2 class="display-6 fw-bold text-primary mb-3">Financial Intelligence</h2>
                        <p class="text-muted lead mb-4">Make data-driven decisions with our integrated revenue tracking system.</p>
                        <div class="p-4 bg-light rounded-4 mb-4">
                            <h6 class="fw-bold mb-3"><i class="fas fa-chart-line me-2 text-success"></i> Key Advantages:</h6>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-white p-2 rounded shadow-sm me-3"><i class="fas fa-wallet text-primary"></i></div>
                                <div class="small">Real-time Collected vs. Pending revenue tracking.</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-white p-2 rounded shadow-sm me-3"><i class="fas fa-receipt text-warning"></i></div>
                                <div class="small">Automated pending fee reminders and history.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-illustration p-5 text-center">
                            <div class="bg-white rounded-circle shadow p-4 d-inline-block position-relative" style="width: 250px; height: 250px;">
                                <div class="h-100 border border-10 rounded-circle border-success d-flex align-items-center justify-content-center">
                                    <div>
                                        <div class="fw-bold lead mb-0">85%</div>
                                        <div class="x-small text-muted">Collected</div>
                                    </div>
                                </div>
                                <div class="position-absolute bg-danger rounded-circle shadow-sm p-3" style="bottom: 10px; right: 10px; width: 80px; height: 80px; border: 4px solid white;">
                                    <div class="text-white text-center">
                                        <div class="fw-bold small mb-0">15%</div>
                                        <div style="font-size: 0.5rem;">Unpaid</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 5: Modules Overview -->
    <div class="presentation-slide mb-5 page-break">
        <div class="slide-content card border-0 shadow-lg overflow-hidden glass-card">
            <div class="card-body p-5">
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold text-primary mb-2">Comprehensive Management Overview</h2>
                    <p class="text-muted">Explore the range of modules that make our platform the #1 choice for educators.</p>
                </div>
                <div class="table-responsive rounded-4 border overflow-hidden">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="p-4">Module Name</th>
                                <th class="p-4 text-center">Benefit</th>
                                <th class="p-4">Key Features</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-primary p-2 rounded flex-shrink-0 me-3"><i class="fas fa-user-check text-primary"></i></div>
                                        <div class="fw-bold">Attendance Control</div>
                                    </div>
                                </td>
                                <td class="p-4 text-center align-middle text-muted small">Maximized punctuality & automated logs</td>
                                <td class="p-4 align-middle text-muted small">Daily logs, monthly summaries, multi-staff tracking</td>
                            </tr>
                            <tr>
                                <td class="p-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-success p-2 rounded flex-shrink-0 me-3"><i class="fas fa-poll-h text-success"></i></div>
                                        <div class="fw-bold">Academic Performance</div>
                                    </div>
                                </td>
                                <td class="p-4 text-center align-middle text-muted small">Accurate result processing</td>
                                <td class="p-4 align-middle text-muted small">Exam management, digital marksheets, notice boards</td>
                            </tr>
                            <tr>
                                <td class="p-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-info p-2 rounded flex-shrink-0 me-3"><i class="fas fa-building text-info"></i></div>
                                        <div class="fw-bold">HR & Admin</div>
                                    </div>
                                </td>
                                <td class="p-4 text-center align-middle text-muted small">Smooth institute operation</td>
                                <td class="p-4 align-middle text-muted small">Teacher management, faculty history, department control</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 6: Thank You -->
    <div class="presentation-slide mb-5">
        <div class="slide-content card border-0 shadow-lg overflow-hidden glass-card bg-gradient-dark text-white text-center p-5">
            <div class="p-5">
                <h1 class="display-3 fw-bold mb-4">Thank You!</h1>
                <p class="lead mb-5 opacity-75">Join the 100+ institutes transforming their future with us.</p>
                <div class="mx-auto" style="max-width: 400px;">
                    <div class="p-4 border border-secondary rounded-4 bg-white bg-opacity-10 backdrop-blur">
                        <h5 class="fw-bold mb-3"><i class="fas fa-headset me-2"></i> Contact for Inquiry</h5>
                        <p class="mb-1"><strong>Phone:</strong> +91 9988776655</p>
                        <p class="mb-0"><strong>Website:</strong> www.coachingcms.com</p>
                    </div>
                </div>
                <div class="mt-5 x-small opacity-50">
                    Proprietary & Confidential - © 2026 Coaching Management System
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for the presentation view */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 40px !important;
    }

    .bg-soft-primary { background: rgba(99, 102, 241, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-info { background: rgba(59, 130, 246, 0.1); }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        border-radius: 12px;
        transition: all 0.3s;
    }

    .bg-gradient-dark {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    }

    .transition-card { transition: all 0.3s; }
    .transition-card:hover { 
        transform: translateY(-5px);
        background: #fff !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    /* Print Styles: Each slide on a new page */
    @media print {
        header, .sidebar, .topbar, footer, .no-print, .btn { display: none !important; }
        .main-wrapper { margin: 0 !important; padding: 0 !important; }
        .main-content { padding: 0 !important; margin: 0 !important; }
        body { background: white !important; }
        .presentation-slide {
            height: 100vh;
            page-break-after: always;
            margin: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .slide-content {
            box-shadow: none !important;
            border: 1px solid #eee !important;
            width: 100%;
            height: 90%;
            transform: scale(0.9);
        }
        .glass-card { background: white !important; }
        .bg-gradient-primary, .bg-gradient-dark { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }

    /* Creative Shapes */
    .floating-shapes .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    .shape-1 { width: 300px; height: 300px; top: -150px; right: -50px; }
    .shape-2 { width: 150px; height: 150px; bottom: -50px; left: 10%; }
</style>
@endsection
