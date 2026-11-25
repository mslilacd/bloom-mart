<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance Report - Bloom Mart</title>

    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bloom Mart Custom High-End CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <!-- Navigation Header -->
    <header class="top-nav sticky-top py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span class="brand-badge">BLOOM MART</span>
                <span class="text-muted fw-semibold">| Attendance Report</span>
            </div>
            <a href="{{ url('/assistant/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="container pb-5">

        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
            <div>
                <h2 class="fw-extrabold mb-1">My Attendance Report</h2>
                <p class="text-muted small mb-0">Filter and view your historical work hours and daily attendance records.</p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="saas-card p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                <i class="bi bi-funnel text-primary fs-5"></i>
                <h5 class="fw-bold mb-0">Filter Report</h5>
            </div>

            <form method="GET" action="{{ url('/assistant/report') }}">
                <div class="row g-3 align-items-end">
                    
                    <!-- Specific Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-secondary">SPECIFIC DATE</label>
                        <input type="date" name="attendance_date" class="form-control" value="{{ $dateFilter }}">
                    </div>

                    <!-- Month -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-secondary">MONTH</label>
                        <select name="month" class="form-select">
                            <option value="">All Months</option>
                            @php
                                $months = [
                                    1 => "January", 2 => "February", 3 => "March", 4 => "April",
                                    5 => "May", 6 => "June", 7 => "July", 8 => "August",
                                    9 => "September", 10 => "October", 11 => "November", 12 => "December"
                                ];
                            @endphp
                            @foreach ($months as $number => $name)
                                <option value="{{ $number }}" {{ (string)$monthFilter === (string)$number ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-secondary">YEAR</label>
                        <select name="year" class="form-select">
                            <option value="">All Years</option>
                            @php
                                $currentYear = (int) date("Y");
                            @endphp
                            @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                                <option value="{{ $year }}" {{ (string)$yearFilter === (string)$year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Filter & Reset Buttons -->
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-saas flex-grow-1 fw-semibold">
                            <i class="bi bi-search me-1"></i> Apply Filter
                        </button>
                        <a href="{{ url('/assistant/report') }}" class="btn btn-outline-secondary fw-semibold">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>

        <!-- Summary Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="saas-card p-3 border-0 shadow-sm d-flex align-items-center gap-3">
                    <div class="bg-primary-subtle text-primary p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-calendar-check fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block">Total Attendance Records</span>
                        <h3 class="fw-extrabold mb-0 text-dark">{{ $totalRecords }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="saas-card p-3 border-0 shadow-sm d-flex align-items-center gap-3">
                    <div class="bg-success-subtle text-success p-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block">Total Working Hours</span>
                        <h3 class="fw-extrabold mb-0 text-success">{{ number_format((float) $totalHours, 2) }} <span class="fs-6 text-muted fw-normal">hrs</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Records Data Card -->
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-table text-secondary fs-4"></i>
                    <div>
                        <h5 class="fw-bold mb-0">Attendance Records</h5>
                        <small class="text-muted">Filtered shift details and worked duration</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">Attendance ID</th>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th class="pe-4 text-end">Total Hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $row)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">#{{ $row->attendance_id }}</td>
                                    <td class="fw-semibold text-secondary">
                                        {{ \Carbon\Carbon::parse($row->attendance_date)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1 fw-semibold">
                                            {{ !empty($row->time_in) ? \Carbon\Carbon::parse($row->time_in)->format('h:i A') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1 fw-semibold">
                                            {{ !empty($row->time_out) ? \Carbon\Carbon::parse($row->time_out)->format('h:i A') : '-' }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end fw-bold text-primary">
                                        {{ number_format((float) $row->total_hours, 2) }} hrs
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        No attendance records found for the selected criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>