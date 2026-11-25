<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Assistant Dashboard - Bloom Mart</title>

    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bloom Mart Custom High-End CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Sidebar & Dashboard Layout CSS -->
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #0d6efd;
            --bg-light: #f8fafc;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Fixed Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .sidebar-menu {
            padding: 1rem 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-menu .nav-link {
            padding: 0.75rem 1.5rem;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
        }

        .sidebar-menu .nav-link:hover,
        .sidebar-menu .nav-link.active {
            color: var(--primary-color);
            background-color: #eef2ff;
            border-left: 4px solid var(--primary-color);
        }

        /* Main Content Shift */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .content-body {
            padding: 2rem;
        }

        /* Stat Metrics Cards */
        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div>
            <!-- Brand Logo -->
            <div class="sidebar-brand d-flex align-items-center gap-2">
                <span class="brand-badge fs-6">BLOOM MART</span>
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ url('/assistant/dashboard') }}" class="nav-link active">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/assistant/schedule') }}" class="nav-link">
                        <i class="bi bi-calendar3"></i> My Schedule
                    </a>
                </li>
                <li>
                    <a href="{{ url('/assistant/attendance') }}" class="nav-link">
                        <i class="bi bi-clock-history"></i> Record Attendance
                    </a>
                </li>
                <li>
                    <a href="{{ url('/assistant/report') }}" class="nav-link">
                        <i class="bi bi-file-earmark-bar-graph"></i> Attendance Report
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Bottom / Logout -->
        <div class="p-3 border-top">
            <a href="{{ url('/logout') }}" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-2 rounded-pill fw-semibold">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Main Workspace Area -->
    <div class="main-wrapper">

        <!-- Top Navigation Header -->
        <header class="top-navbar">
            <div class="text-muted fw-semibold">
                Store Assistant Portal
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold text-dark small">{{ session('name') ?? 'Store Assistant' }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">Store Assistant</div>
                </div>
            </div>
        </header>

        <!-- Content Body -->
        <main class="content-body">

            <!-- Hero Welcome Header -->
            <div class="saas-card p-4 p-md-4 mb-4 bg-white border-0 shadow-sm rounded-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                        <i class="bi bi-person-badge fs-3"></i>
                    </div>
                    <div>
                        <h3 class="fw-extrabold mb-1">Welcome back, {{ session('name') }}! 👋</h3>
                        <p class="text-muted small mb-0">Manage your shifts, punch clock, and attendance logs from your workspace.</p>
                    </div>
                </div>
            </div>

            <!-- Stats & Quick Overview Section -->
            <div class="row g-3 mb-4">
                
                <!-- Monthly Work Hours -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Monthly Logged Hours</span>
                            <h3 class="fw-extrabold text-dark my-1">{{ $monthlyHours ?? 0 }} hrs</h3>
                            <span class="text-success small fw-semibold"><i class="bi bi-check-circle me-1"></i> Recorded time</span>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-stopwatch-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Shifts -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Upcoming Shifts</span>
                            <h3 class="fw-extrabold text-dark my-1">{{ $upcomingShifts ?? 0 }}</h3>
                            <span class="text-muted small">Assigned roster</span>
                        </div>
                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                </div>

                <!-- Today's Attendance Status -->
                <div class="col-12 col-sm-6 col-xl-4">
                    <div class="stat-card d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Today's Duty Status</span>
                            <h4 class="fw-bold text-dark my-1">{{ $todayStatus ?? 'Not Clocked In' }}</h4>
                            <span class="text-secondary small">Daily Record</span>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Dashboard Modules Navigation -->
            <h5 class="fw-bold mb-3 text-secondary text-uppercase fs-6" style="letter-spacing: 0.05em;">Workspace Modules</h5>

            <div class="row g-4">

                <!-- Card 1: Schedule -->
                <div class="col-md-4">
                    <div class="saas-card h-100 p-4 border-0 shadow-sm d-flex flex-column justify-content-between bg-white rounded-4">
                        <div>
                            <div class="bg-info-subtle text-info p-3 rounded-3 mb-3 d-inline-block">
                                <i class="bi bi-calendar3 fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">My Schedule</h5>
                            <p class="text-muted small">View assigned work shifts, store locations, and upcoming roster timetables.</p>
                        </div>
                        <a href="{{ url('/assistant/schedule') }}" class="btn btn-outline-primary w-100 rounded-pill fw-semibold mt-3">
                            View My Schedule <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Attendance -->
                <div class="col-md-4">
                    <div class="saas-card h-100 p-4 border-0 shadow-sm d-flex flex-column justify-content-between bg-white rounded-4">
                        <div>
                            <div class="bg-success-subtle text-success p-3 rounded-3 mb-3 d-inline-block">
                                <i class="bi bi-clock-history fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Record Attendance</h5>
                            <p class="text-muted small">Punch Time In, Time Out, and request verification for missed attendance entries.</p>
                        </div>
                        <a href="{{ url('/assistant/attendance') }}" class="btn btn-saas w-100 rounded-pill fw-semibold mt-3">
                            Record Attendance <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 3: Reports -->
                <div class="col-md-4">
                    <div class="saas-card h-100 p-4 border-0 shadow-sm d-flex flex-column justify-content-between bg-white rounded-4">
                        <div>
                            <div class="bg-warning-subtle text-warning-emphasis p-3 rounded-3 mb-3 d-inline-block">
                                <i class="bi bi-file-earmark-bar-graph fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-2">Attendance Report</h5>
                            <p class="text-muted small">Inspect worked hours history, overall attendance summary, and monthly logs.</p>
                        </div>
                        <a href="{{ url('/assistant/report') }}" class="btn btn-outline-secondary w-100 rounded-pill fw-semibold mt-3">
                            View Report <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>