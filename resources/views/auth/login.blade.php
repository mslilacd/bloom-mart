<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloom Mart Login</title>

    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bloom Mart Custom High-End CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100 py-5">

    <main class="container" style="max-width: 440px;">
        
        <!-- Header Branding -->
        <div class="text-center mb-4">
            <span class="brand-badge fs-6 px-3 py-2 mb-3 d-inline-block">BLOOM MART</span>
            <h3 class="fw-extrabold text-dark mb-1">Welcome Back</h3>
            <p class="text-muted small">Profiling and Attendance System</p>
        </div>

        <!-- Login Card -->
        <div class="saas-card p-4 p-md-5 bg-white border-0 shadow-sm rounded-4">

            {{-- Displays error message if login credentials fail --}}
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0"></i>
                    <div class="small fw-semibold">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf {{-- Required by Laravel to prevent CSRF security errors --}}

                <!-- Email Input -->
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">EMAIL ADDRESS</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="name@bloommart.com" required>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="••••••••" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-saas w-100 py-2.5 rounded-pill fw-semibold shadow-sm">
                    Sign In <i class="bi bi-box-arrow-in-right ms-1"></i>
                </button>

            </form>

        </div>

        <!-- System Footer Note -->
        <div class="text-center mt-4">
            <p class="text-muted extra-small mb-0">&copy; {{ date('Y') }} Bloom Mart. All rights reserved.</p>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>