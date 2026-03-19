<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Portal - {{ $currentCoaching->coaching_name ?? 'Coaching' }}</title>
    
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
            --primary-color: #0ea5e9;
            --secondary-color: #2563eb;
            --sidebar-width: 260px;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }

        .sidebar { 
            width: var(--sidebar-width);
            min-height: 100vh; 
            max-height: 100vh;
            overflow-y: auto;
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(10px);
            padding: 25px 15px;
            position: fixed;
            z-index: 1000;
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
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
            transform: translateX(8px);
        }

        .sidebar a.active { 
            color: #fff; 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); 
            box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3);
            animation: pulse-faculty 2s infinite;
        }

        .sidebar a i { width: 24px; margin-right: 12px; transition: transform 0.2s; }
        .sidebar a.active i { transform: scale(1.15); }

        @keyframes pulse-faculty {
            0% { box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3); }
            50% { box-shadow: 0 10px 25px -3px rgba(14, 165, 233, 0.5); }
            100% { box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3); }
        }

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
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); transition: 0.3s; }
            .main-wrapper { margin-left: 0; }
            .sidebar.mobile-show { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="nav-brand">
            <i class="fas fa-user-tie me-2 text-info"></i>
            Faculty Portal
        </div>
        
        <div class="nav-menu">
            <a href="{{ route('faculty.dashboard') }}" class="{{ request()->routeIs('faculty.dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('faculty.attendance') }}" class="{{ request()->routeIs('faculty.attendance') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> My Attendance
            </a>
            <a href="{{ route('faculty.salary-slips.index') }}" class="{{ request()->routeIs('faculty.salary-slips.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> Salary Slips
            </a>
            <a href="{{ route('faculty.profile') }}" class="{{ request()->routeIs('faculty.profile') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> My Profile
            </a>
            <hr class="text-secondary opacity-25 mx-3 my-4">
            <a href="{{ route('faculty.notices') }}" class="{{ request()->routeIs('faculty.notices') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Notices
            </a>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button class="btn d-lg-none me-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="m-0 fw-bold text-dark">{{ $currentCoaching->coaching_name ?? 'Faculty Dashboard' }}</h5>
            </div>
            
            <div class="dropdown">
                @php
                    $facultyProfile = \App\Models\Faculty::where('email', auth()->user()->email)->first();
                @endphp
                <button class="btn d-flex align-items-center dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                    <span class="fw-semibold me-2 text-dark">{{ auth()->user()->name }}</span>
                    @if($facultyProfile && $facultyProfile->profile_image)
                        <img src="{{ asset($facultyProfile->profile_image) }}" alt="Profile" class="rounded-circle shadow-sm" style="width: 35px; height: 35px; object-fit: cover;">
                    @else
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2">
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('faculty.profile') }}">
                            <i class="fas fa-user-circle me-2"></i> My Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-50"></li>
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
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
                    {{ session('error') }}
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
        }
    </script>
</body>
</html>
