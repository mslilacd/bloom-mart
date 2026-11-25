<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report - Bloom Mart</title>

    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Bloom Mart Custom High-End CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

    <!-- Header Navigation -->
    <header class="top-nav sticky-top py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span class="brand-badge">BLOOM MART</span>
                <span class="text-muted fw-semibold">| Attendance Reports</span>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="container pb-5">
        
        <!-- Page Title & Overview -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
            <div>
                <h2 class="fw-extrabold mb-1">Attendance Report</h2>
                <p class="text-muted small mb-0">Filter and view staff attendance records, work hours, and active statuses.</p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="saas-card p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-funnel-fill text-primary fs-5"></i>
                <h5 class="fw-bold mb-0">Filter Report</h5>
            </div>

            <form method="GET" action="{{ url('/admin/report') }}">
                <div class="row g-3">
                    
                    <!-- Store Assistant Filter -->
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label fw-semibold small text-secondary">STORE ASSISTANT</label>
                        <select name="user_id" class="form-select">
                            <option value="0">All Store Assistants</option>
                            @foreach ($assistants as $assistant)
                                <option value="{{ $assistant->user_id }}" {{ request('user_id') == $assistant->user_id ? 'selected' : '' }}>
                                    {{ $assistant->name }} {{ $assistant->status === 'inactive' ? '(Inactive)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Specific Date Filter -->
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label fw-semibold small text-secondary">SPECIFIC DATE</label>
                        <input type="date" name="attendance_date" class="form-control" value="{{ request('attendance_date') }}">
                    </div>

                    <!-- Month Filter -->
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label fw-semibold small text-secondary">MONTH</label>
                        <select name="month" class="form-select">
                            <option value="">All Months</option>
                            @php
                                $months = [
                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                ];
                            @endphp
                            @foreach ($months as $number => $name)
                                <option value="{{ $number }}" {{ request('month') == $number ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Filter -->
                    <div class="col-md-6 col-lg-3">
                        <label class="form-label fw-semibold small text-secondary">YEAR</label>
                        <select name="year" class="form-select">
                            <option value="">All Years</option>
                            @php
                                $current_year = date('Y');
                            @endphp
                            @for ($year = $current_year; $year >= $current_year - 5; $year--)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>

                </div>

                <!-- Filter Actions -->
                <div class="d-flex align-items-center gap-2 mt-4 pt-2 border-top">
                    <button type="submit" class="btn btn-saas px-4">
                        <i class="bi bi-filter me-1"></i> Apply Filter
                    </button>
                    <a href="{{ url('/admin/report') }}" class="btn btn-outline-secondary px-4">Reset</a>
                </div>
            </form>
        </div>

        <!-- Summary Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="saas-card p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-semibold small text-uppercase">Total Attendance Records</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1">{{ $total_records }}</h3>
                    </div>
                    <div class="icon-wrapper mb-0">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="saas-card p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fw-semibold small text-uppercase">Total Working Hours</span>
                        <h3 class="fw-extrabold text-primary mb-0 mt-1">{{ number_format($grand_total_hours, 2) }} hrs</h3>
                    </div>
                    <div class="icon-wrapper mb-0">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white">
                <h5 class="fw-bold mb-0">Attendance Records</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4">Attendance ID</th>
                            <th>Store Assistant</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Total Hours</th>
                            <th class="pe-4 text-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $row)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#{{ $row->attendance_id }}</td>
                                <td class="fw-bold text-dark">{{ $row->user->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-semibold px-2 py-1">
                                        {{ $row->user->type ?? '-' }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->attendance_date)->format('d M Y') }}</td>
                                <td class="text-success fw-semibold">
                                    {{ $row->time_in ? \Carbon\Carbon::parse($row->time_in)->format('h:i A') : '-' }}
                                </td>
                                <td class="text-danger fw-semibold">
                                    {{ $row->time_out ? \Carbon\Carbon::parse($row->time_out)->format('h:i A') : '-' }}
                                </td>
                                <td class="fw-bold">{{ number_format((float)$row->total_hours, 2) }}</td>
                                <td class="pe-4 text-end">
                                    @if(($row->user->status ?? '') === 'active')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-semibold">Active</span>
                                    @elseif(($row->user->status ?? '') === 'inactive')
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1 fw-semibold">Inactive</span>
                                    @else
                                        <span class="badge bg-light text-muted border rounded-pill px-3 py-1">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    No attendance records found for the selected criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>