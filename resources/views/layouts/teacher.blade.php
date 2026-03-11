<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal - {{ $currentCoaching->coaching_name ?? 'Coaching' }}</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --sidebar-width: 260px;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }

        .sidebar { 
            width: var(--sidebar-width);
            min-height: 100vh; 
            background: rgba(30, 41, 59, 0.98);
            backdrop-filter: blur(10px);
            padding: 25px 15px;
            position: fixed;
            z-index: 1000;
        }

        .sidebar .nav-brand {
            padding: 0 15px 30px;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
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

        .sidebar a:hover { 
            color: #fff; 
            background: rgba(255, 255, 255, 0.05); 
        }

        .sidebar a.active { 
            color: #fff; 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); 
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .sidebar a i { width: 24px; margin-right: 12px; }

        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar { 
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            padding: 15px 40px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid var(--glass-border);
        }

        .main-content { padding: 40px; }

        .card { 
            background: var(--glass-bg);
            backdrop-filter: blur(8px);
            border: 1px solid var(--glass-border);
            border-radius: 20px; 
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

        @media (max-width: 992px) {
            .sidebar { 
                transform: translateX(-100%); 
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .main-wrapper { margin-left: 0; }
            .sidebar.mobile-show { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="sidebar" id="sidebar">
        <div class="nav-brand">
            <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
            Teacher Portal
        </div>
        
        <div class="nav-menu">
            <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> My Dashboard
            </a>
            <a href="{{ route('teacher.batches') }}" class="{{ request()->routeIs('teacher.batches*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Assigned Batches
            </a>
            <a href="{{ route('teacher.students') }}" class="{{ request()->routeIs('teacher.students*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> My Students
            </a>
            <a href="{{ route('teacher.attendance.index') }}" class="{{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Mark Attendance
            </a>
            <a href="{{ route('teacher.exams') }}" class="{{ request()->routeIs('teacher.exams*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice"></i> Conduct Exam
            </a>
            <a href="{{ route('teacher.salary-slips.index') }}" class="{{ request()->routeIs('teacher.salary-slips.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> My Salary Slips
            </a>
            <hr class="text-secondary opacity-25 mx-3 my-4">
            <a href="{{ route('teacher.notices') }}">
                <i class="fas fa-bullhorn"></i> View Notices
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button class="btn d-lg-none me-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars fs-4"></i>
                </button>
                <h5 class="m-0 fw-bold">{{ $currentCoaching->coaching_name ?? 'Coaching Center' }}</h5>
            </div>
            
            <div class="dropdown">
                <button class="btn d-flex align-items-center dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                    <span class="fw-semibold me-2">{{ auth()->user()->name }}</span>
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2">
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

        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
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
    </script>

    @stack('scripts')
</body>
</html>
