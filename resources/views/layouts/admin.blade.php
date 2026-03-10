<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Premium Control Center</title>
    
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
            --primary-color: #4f46e5; /* Indigo */
            --secondary-color: #0ea5e9; /* Sky */
            --dark-bg: #030712;
            --sidebar-width: 280px;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body { 
            font-family: 'Outfit', sans-serif; 
            background: radial-gradient(circle at top right, #e0e7ff, #f8fafc);
            min-height: 100vh;
            color: #111827;
        }

        /* Premium Sidebar */
        .sidebar { 
            width: var(--sidebar-width);
            min-height: 100vh; 
            background: #1e1b4b; /* Deep Indigo */
            padding: 30px 20px;
            position: fixed;
            z-index: 1000;
        }

        .sidebar .nav-brand {
            padding: 0 15px 40px;
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .sidebar a { 
            color: #94a3b8; 
            text-decoration: none; 
            padding: 14px 20px; 
            display: flex;
            align-items: center;
            border-radius: 16px;
            margin-bottom: 10px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar a i { 
            width: 28px; 
            font-size: 1.25rem; 
            margin-right: 12px;
        }

        .sidebar a:hover { 
            color: #fff; 
            background: rgba(255, 255, 255, 0.05); 
        }

        .sidebar a.active { 
            color: #fff; 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); 
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

        /* Layout */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        .topbar { 
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--glass-border);
            padding: 20px 45px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .main-content { 
            padding: 45px; 
        }

        /* Premium Card */
        .card { 
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 24px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .card-header {
            background: transparent !important;
            border-bottom: 1px solid rgba(0,0,0,0.05) !important;
            padding: 25px 30px !important;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 14px;
            font-weight: 600;
            box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.3);
            transition: all 0.3s;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            color: white;
        }

        .badge-premium {
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Gradients */
        .bg-indigo { background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); }
        .bg-emerald { background: linear-gradient(135deg, #10b981 0%, #065f46 100%); }
        .bg-rose { background: linear-gradient(135deg, #f43f5e 0%, #9f1239 100%); }
        .bg-amber { background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%); }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Sidebar -->
        <div class="sidebar animate__animated animate__fadeInLeft">
            <div class="nav-brand">
                <i class="fas fa-shield-alt text-primary me-2"></i>
                <span>Super Admin</span>
            </div>
            
            <div class="nav-menu">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.coachings.index') }}" class="{{ request()->routeIs('admin.coachings.*') ? 'active' : '' }}">
                    <i class="fas fa-university"></i> Coachings
                </a>
                <a href="{{ route('admin.system-users.index') }}" class="{{ request()->routeIs('admin.system-users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> System Users
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i> User Roles
                </a>
                <a href="#">
                    <i class="fas fa-sliders-h"></i> System Settings
                </a>
            </div>
        </div>

        <div class="main-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <h5 class="m-0 fw-bold animate__animated animate__fadeIn">Central Control Panel</h5>
                
                <div class="dropdown">
                    <button class="btn d-flex align-items-center dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                        <div class="avatar-sm bg-indigo text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="text-start d-none d-sm-block">
                            <div class="fw-bold small">{{ auth()->user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Global Admin</div>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2">
                        <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                    <i class="fas fa-power-off me-2"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-4 py-3 mb-4 animate__animated animate__fadeInDown" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('scripts')
</body>
</html>
