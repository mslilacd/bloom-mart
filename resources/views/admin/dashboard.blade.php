<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bloom Mart</title>

    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bloom Mart Custom High-End CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Dashboard Sidebar Layout CSS -->
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

        /* Main Content Wrapper Shift */
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

        /* Metric Stat Cards */
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

            <!-- Sidebar Links -->
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link active">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/users/create') }}" class="nav-link">
                        <i class="bi bi-person-plus-fill"></i> Register User
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/manage-users') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i> Manage Users
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/schedules') }}" class="nav-link">
                        <i class="bi bi-calendar3"></i> Staff Schedules
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/verifications') }}" class="nav-link">
                        <i class="bi bi-clock-history"></i> Verifications
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/report') }}" class="nav-link">
                        <i class="bi bi-bar-chart-line-fill"></i> System Reports
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

    <!-- Main Content Area -->
    <div class="main-wrapper">

        <!-- Top Header Bar -->
        <header class="top-navbar">
            <div class="text-muted fw-semibold">
                Admin Console
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="text-end d-none d-sm-block">
                    <div class="fw-bold text-dark small">Admin Bloom</div>
                    <div class="text-muted" style="font-size: 0.75rem;">System Administrator</div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="content-body">
            
            <!-- Welcome Header -->
            <div class="mb-4">
                <h2 class="fw-extrabold mb-1">Welcome back, Admin 👋</h2>
                <p class="text-muted small">Here is an overview of your store management control panel today.</p>
            </div>

            <!-- Metric Summary Section -->
            <div class="row g-3 mb-4">
                <!-- Total Store Assistants -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Assistants</span>
                            <h3 class="fw-extrabold text-dark my-1">{{ $totalAssistants ?? 0 }}</h3>
                            <span class="text-success small fw-semibold"><i class="bi bi-check-circle me-1"></i>Active accounts</span>
                        </div>
                        <div class="stat-icon bg-primary-subtle text-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Assigned Duty Shifts -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Shifts</span>
                            <h3 class="fw-extrabold text-dark my-1">{{ $totalSchedules ?? 0 }}</h3>
                            <span class="text-muted small">Scheduled shifts</span>
                        </div>
                        <div class="stat-icon bg-info-subtle text-info">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Clock-In Verifications -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Verifications</span>
                            <h3 class="fw-extrabold text-dark my-1">{{ $pendingVerifications ?? 0 }}</h3>
                            <span class="text-warning small fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>Requires action</span>
                        </div>
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Hours Logged -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Work Hours</span>
                            <h3 class="fw-extrabold text-dark my-1">{{ $totalWorkHours ?? 0 }} hrs</h3>
                            <span class="text-success small">Recorded work time</span>
                        </div>
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-stopwatch-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Management Modules Section -->
            <h5 class="fw-bold mb-3 text-secondary text-uppercase fs-6" style="letter-spacing: 0.05em;">Management Modules</h5>
            
            <div class="row g-4">
                
                <!-- Card 1: Register Users -->
                <div class="col-md-6 col-lg-4">
                    <div class="saas-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="icon-wrapper mb-3">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Register Users</h5>
                            <p class="text-muted small mb-0">Add new admin profiles or store assistants to the active database.</p>
                        </div>
                        <div class="pt-4">
                            <a href="{{ url('/admin/users/create') }}" class="btn btn-saas w-100 d-flex align-items-center justify-content-center gap-2">
                                <span>Register Records</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Manage Users -->
                <div class="col-md-6 col-lg-4">
                    <div class="saas-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="icon-wrapper mb-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Manage Users</h5>
                            <p class="text-muted small mb-0">Search, filter, view status, and manage assistant user accounts.</p>
                        </div>
                        <div class="pt-4">
                            <a href="{{ url('/admin/manage-users') }}" class="btn btn-saas w-100 d-flex align-items-center justify-content-center gap-2">
                                <span>User Management</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Staff Schedules -->
                <div class="col-md-6 col-lg-4">
                    <div class="saas-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="icon-wrapper mb-3">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Staff Schedules</h5>
                            <p class="text-muted small mb-0">Organize, assign shifts, and set weekly duty schedules for staff.</p>
                        </div>
                        <div class="pt-4">
                            <a href="{{ url('/admin/schedules') }}" class="btn btn-saas w-100 d-flex align-items-center justify-content-center gap-2">
                                <span>Manage Schedule</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Verifications -->
                <div class="col-md-6 col-lg-4">
                    <div class="saas-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="icon-wrapper mb-3">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">Verifications</h5>
                            <p class="text-muted small mb-0">Review pending clock-in and clock-out adjustment requests.</p>
                        </div>
                        <div class="pt-4">
                            <a href="{{ url('/admin/verifications') }}" class="btn btn-saas w-100 d-flex align-items-center justify-content-center gap-2">
                                <span>Review Requests</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 5: System Reports -->
                <div class="col-md-6 col-lg-4">
                    <div class="saas-card h-100 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="icon-wrapper mb-3">
                                <i class="bi bi-bar-chart-line-fill"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">System Reports</h5>
                            <p class="text-muted small mb-0">Generate, filter, and review working hour logs and assistant metrics.</p>
                        </div>
                        <div class="pt-4">
                            <a href="{{ url('/admin/report') }}" class="btn btn-saas w-100 d-flex align-items-center justify-content-center gap-2">
                                <span>View Reports</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>