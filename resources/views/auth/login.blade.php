<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Coaching Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            color: #fff;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: -webkit-linear-gradient(#fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-header h3 {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 0.8rem;
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: #fff;
            color: #764ba2;
            border: none;
            border-radius: 0.8rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: #f8f9fa;
            color: #5a3780;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .form-check-input:checked {
            background-color: #fff;
            border-color: #fff;
        }

        .forgot-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #fff;
            text-decoration: underline;
        }

        .text-danger {
            color: #ff6b6b !important;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-graduation-cap"></i>
            <h3>Welcome Back</h3>
            <p>Sign in to the Coaching Management System</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success bg-transparent text-white border-0 shadow-sm" style="background: rgba(40, 167, 69, 0.2) !important;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.8); border-radius: 0.8rem 0 0 0.8rem;">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input id="email" type="email" class="form-control border-start-0 ps-0" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com" style="border-radius: 0 0.8rem 0.8rem 0;">
                </div>
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(255,255,255,0.2); color: rgba(255,255,255,0.8); border-radius: 0.8rem 0 0 0.8rem;">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" type="password" class="form-control border-start-0 ps-0" name="password" required autocomplete="current-password" placeholder="••••••••" style="border-radius: 0 0.8rem 0.8rem 0;">
                </div>
                @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary shadow">
                <i class="fas fa-sign-in-alt me-2"></i> Log in
            </button>
        </form>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
