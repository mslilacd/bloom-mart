<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Schedule - Bloom Mart</title>

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
                <span class="text-muted fw-semibold">| My Schedule</span>
            </div>
            <a href="{{ url('/assistant/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="container pb-5" style="max-width: 960px;">

        <!-- Page Header -->
        <div class="mb-4">
            <h2 class="fw-extrabold mb-1">My Work Schedule</h2>
            <p class="text-muted small mb-0">View your assigned shifts, dates, and scheduled operational hours.</p>
        </div>

        <!-- Schedule Table Card -->
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-calendar3 text-primary fs-4"></i>
                    <div>
                        <h5 class="fw-bold mb-0">Assigned Roster</h5>
                        <small class="text-muted">Current shift assignments and timetables</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Shift</th>
                                <th>Start Time</th>
                                <th class="pe-4">End Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $row)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        <i class="bi bi-calendar-event me-2 text-muted"></i>{{ $row->schedule_date }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-semibold">
                                            {{ $row->shift }}
                                        </span>
                                    </td>
                                    <td class="fw-semibold text-secondary">
                                        <i class="bi bi-clock me-1 text-muted"></i>{{ $row->start_time }}
                                    </td>
                                    <td class="pe-4 fw-semibold text-secondary">
                                        <i class="bi bi-clock-history me-1 text-muted"></i>{{ $row->end_time }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i>
                                        No schedule records found.
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