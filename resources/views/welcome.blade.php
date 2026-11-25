<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Bloom Mart') }}</title>

    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Bloom Mart Custom High-End CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Top Navigation Header -->
    <header class="top-nav sticky-top py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span class="brand-badge fs-6 px-3 py-2">BLOOM MART</span>
            </div>

            @if (Route::has('login'))
                <nav class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-saas btn-sm px-4 rounded-pill fw-semibold shadow-sm">
                            Dashboard <i class="bi bi-speedometer2 ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-4 rounded-pill fw-semibold">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-saas btn-sm px-4 rounded-pill fw-semibold shadow-sm">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Hero Section -->
    <main class="container my-auto py-5" style="max-width: 960px;">
        <div class="row align-items-center g-5">
            
            <!-- Left Hero Information -->
            <div class="col-lg-7">
                <div class="mb-3">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-semibold small">
                        <i class="bi bi-shield-check me-1"></i> Internal Portal
                    </span>
                </div>
                <h1 class="fw-extrabold text-dark display-5 mb-3">
                    Profiling & Attendance System
                </h1>
                <p class="text-muted lead fs-6 mb-4">
                    Streamline staff shift management, record daily clock-ins, and manage team profiles with precision and ease.
                </p>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-3 mb-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-saas px-4 py-2.5 rounded-pill fw-semibold shadow-sm">
                            Go to Dashboard <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-saas px-4 py-2.5 rounded-pill fw-semibold shadow-sm">
                            Sign In to Portal <i class="bi bi-box-arrow-in-right ms-1"></i>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-pill fw-semibold">
                                Create Account
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Feature Card -->
            <div class="col-lg-5">
                <div class="saas-card p-4 bg-white border-0 shadow-sm rounded-4">
                    <h5 class="fw-bold mb-3 text-dark">System Quick Features</h5>
                    
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="p-2 bg-primary-subtle rounded-3 text-primary">
                            <i class="bi bi-calendar3 fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">Roster Scheduling</h6>
                            <small class="text-muted">Track store operational shifts and duty timetables.</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="p-2 bg-primary-subtle rounded-3 text-primary">
                            <i class="bi bi-clock-history fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">Attendance Tracking</h6>
                            <small class="text-muted">Log shift start/end times with instant verification.</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="p-2 bg-primary-subtle rounded-3 text-primary">
                            <i class="bi bi-person-badge fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-0">Staff Profiling</h6>
                            <small class="text-muted">Maintain secure employee records and access roles.</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center border-top bg-white mt-auto">
        <div class="container">
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} Bloom Mart. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>