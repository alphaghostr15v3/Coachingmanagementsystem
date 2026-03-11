<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentCoaching->coaching_name ?? 'Coaching Admin' }} - Premium Portal</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #a855f7;
            --dark-bg: #0f172a;
            --sidebar-width: 260px;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
            color: #1e293b;
        }

        /* Glassmorphism Sidebar */
        .sidebar { 
            width: var(--sidebar-width);
            min-height: 100vh; 
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            padding: 25px 15px;
            position: fixed;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar .nav-brand {
            padding: 0 15px 30px;
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar a { 
            color: #94a3b8; 
            text-decoration: none; 
            padding: 12px 18px; 
            display: flex;
            align-items: center;
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .sidebar a i { 
            width: 24px; 
            font-size: 1.2rem; 
            margin-right: 12px;
            transition: transform 0.2s;
        }

        .sidebar a:hover { 
            color: #fff; 
            background: rgba(255, 255, 255, 0.1); 
            transform: translateX(5px);
        }

        .sidebar a.active { 
            color: #fff; 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); 
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        .sidebar a.active i {
            transform: scale(1.1);
        }

        /* Layout */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar { 
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            padding: 15px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .main-content { 
            padding: 40px; 
            flex-grow: 1;
        }

        /* Glass Cards */
        .card { 
            background: var(--glass-bg);
            backdrop-filter: blur(8px);
            border: 1px solid var(--glass-border);
            border-radius: 20px; 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Utilities */
        .bg-gradient-primary { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); }
        .bg-gradient-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .bg-gradient-info { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .bg-gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
        }

        .badge-soft {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(3px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
            .sidebar.mobile-show { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Mobile Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="nav-brand">
                <i class="fas fa-graduation-cap me-2"></i>
                <span class="d-inline-block">{{ $currentCoaching->coaching_name ?? 'Coaching' }}</span>
            </div>
            
            <div class="nav-menu">
                <a href="{{ route('coaching.dashboard') }}" class="{{ request()->routeIs('coaching.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="{{ route('coaching.students.index') }}" class="{{ request()->routeIs('coaching.students.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i> Students
                </a>
                <a href="{{ route('coaching.teachers.index') }}" class="{{ request()->routeIs('coaching.teachers.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i> Teachers
                </a>
                <a href="{{ route('coaching.courses.index') }}" class="{{ request()->routeIs('coaching.courses.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i> Courses
                </a>
                <a href="{{ route('coaching.batches.index') }}" class="{{ request()->routeIs('coaching.batches.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group"></i> Batches
                </a>
                <a href="{{ route('coaching.fees.index') }}" class="{{ request()->routeIs('coaching.fees.*') ? 'active' : '' }}">
                    <i class="fas fa-wallet"></i> Fees & Revenue
                </a>
                <a href="{{ route('coaching.salary-slips.index') }}" class="{{ request()->routeIs('coaching.salary-slips.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i> Salary Slips
                </a>
                <a href="{{ route('coaching.attendance.index') }}" class="{{ request()->routeIs('coaching.attendance.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i> Attendance
                </a>
                
                <div class="small text-uppercase text-secondary fw-bold mt-4 mb-2 ps-3" style="font-size: 0.65rem; padding-left: 18px !important; opacity: 0.5;">Academic Control</div>
                
                <a href="{{ route('coaching.exams.index') }}" class="{{ request()->routeIs('coaching.exams.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> Exams
                </a>
                <a href="{{ route('coaching.marks.index') }}" class="{{ request()->routeIs('coaching.marks.*') ? 'active' : '' }}">
                    <i class="fas fa-poll-h"></i> Marks
                </a>
                <a href="{{ route('coaching.notices.index') }}" class="{{ request()->routeIs('coaching.notices.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Notices
                </a>
            </div>
        </div>

        <div class="main-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <div class="d-flex align-items-center">
                    <button class="btn d-lg-none me-3" onclick="toggleSidebar()">
                        <i class="fas fa-bars fs-4"></i>
                    </button>
                    <h5 class="m-0 fw-bold animate__animated animate__fadeIn">Coaching Portal</h5>
                </div>
                
                <div class="dropdown">
                    <button class="btn d-flex align-items-center dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="fw-semibold d-none d-sm-inline">{{ auth()->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2">
                        <li><a class="dropdown-item py-2" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show rounded-4 py-3 mb-4 animate__animated animate__fadeInDown" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show rounded-4 py-3 mb-4 animate__animated animate__fadeInDown" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            
            <footer class="text-center py-4 text-muted small">
                &copy; {{ date('Y') }} Coaching Management System. Build with <i class="fas fa-heart text-danger"></i>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('mobile-show');
            const overlay = document.getElementById('sidebarOverlay');
            if (overlay.classList.contains('show')) {
                overlay.classList.remove('show');
                setTimeout(() => overlay.style.display = 'none', 300);
            } else {
                overlay.style.display = 'block';
                setTimeout(() => overlay.classList.add('show'), 10);
            }
        }

        // Auto-close alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
