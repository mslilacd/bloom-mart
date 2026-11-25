<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance & Verification - Bloom Mart</title>

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
                <span class="text-muted fw-semibold">| Attendance Portal</span>
            </div>
            <a href="{{ url('/assistant/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="container pb-5">

        <!-- Page Title -->
        <div class="mb-4">
            <h2 class="fw-extrabold mb-1">Attendance Management</h2>
            <p class="text-muted small mb-0">Record your daily work shifts and manage attendance verification requests.</p>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Error Alert --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validation Errors Alert --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-octagon-fill text-danger fs-5"></i>
                    <strong class="text-danger">Please fix the following issues:</strong>
                </div>
                <ul class="mb-0 ps-4 text-danger small">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 mb-5">
            
            <!-- Section 1: Today's Punch Clock Card -->
            <div class="col-lg-5">
                <div class="saas-card h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-clock-history text-primary fs-4"></i>
                            <h5 class="fw-bold mb-0">Today's Attendance</h5>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-semibold">
                            Shift Status
                        </span>
                    </div>

                    <div class="bg-light p-3 rounded-3 mb-4">
                        <div class="row text-center g-2">
                            <div class="col-6 border-end">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Date</small>
                                <span class="fw-bold text-dark fs-6">{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('d M Y') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.75rem;">Current Time</small>
                                <span class="fw-bold text-primary fs-6">{{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Today Summary Stats Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered align-middle text-center mb-0">
                            <thead class="table-light text-secondary small">
                                <tr>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Total Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 fw-semibold text-dark">
                                        {{ ($todayAttendance && !empty($todayAttendance->time_in)) ? \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') : '-' }}
                                    </td>
                                    <td class="py-2 fw-semibold text-dark">
                                        {{ ($todayAttendance && !empty($todayAttendance->time_out)) ? \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i A') : '-' }}
                                    </td>
                                    <td class="py-2 fw-bold text-primary">
                                        {{ $todayAttendance ? number_format((float) $todayAttendance->total_hours, 2) : '0.00' }} hrs
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ url('/assistant/attendance/time-in') }}" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-saas w-100 py-2 fw-semibold" onclick="return confirm('Confirm recording Time In now?');"
                                {{ ($todayAttendance && !empty($todayAttendance->time_in)) ? 'disabled' : '' }}>
                                <i class="bi bi-box-arrow-in-right me-1"></i> Record Time In
                            </button>
                        </form>

                        <form method="POST" action="{{ url('/assistant/attendance/time-out') }}" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-semibold" onclick="return confirm('Confirm recording Time Out now?');"
                                {{ (!$todayAttendance || empty($todayAttendance->time_in) || !empty($todayAttendance->time_out)) ? 'disabled' : '' }}>
                                <i class="bi bi-box-arrow-left me-1"></i> Record Time Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Section 2: Request Attendance Verification Form -->
            <div class="col-lg-7">
                <div class="saas-card h-100 p-4">
                    <div class="d-flex align-items-center gap-2 pb-3 mb-3 border-bottom">
                        <i class="bi bi-shield-check text-warning fs-4"></i>
                        <div>
                            <h5 class="fw-bold mb-0">Request Attendance Verification</h5>
                            <small class="text-muted">Submit an appeal if you missed recording Time In or Time Out</small>
                        </div>
                    </div>

                    <form method="POST" action="{{ url('/assistant/attendance/verification') }}" onsubmit="return confirm('Are you sure you want to submit this verification request?');">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">ATTENDANCE DATE *</label>
                                <input type="date" name="attendance_date" class="form-control" max="{{ $today }}" value="{{ old('attendance_date', $today) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">VERIFICATION TYPE *</label>
                                <select name="request_type" class="form-select" required>
                                    <option value="">Select Verification Type</option>
                                    <option value="time_in" {{ old('request_type') === 'time_in' ? 'selected' : '' }}>Missed Time In</option>
                                    <option value="time_out" {{ old('request_type') === 'time_out' ? 'selected' : '' }}>Missed Time Out</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold small text-secondary">ACTUAL TIME *</label>
                                <input type="time" name="requested_time" class="form-control" value="{{ old('requested_time') }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold small text-secondary">REASON *</label>
                                <textarea name="reason" class="form-control" rows="3" maxlength="255" placeholder="Explain why you missed recording the attendance..." required>{{ old('reason') }}</textarea>
                            </div>

                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2">
                                    <i class="bi bi-send-fill me-1"></i> Submit Verification Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Section 3: Verification Requests History Card -->
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-journal-text text-secondary fs-4"></i>
                    <div>
                        <h5 class="fw-bold mb-0">My Verification Requests</h5>
                        <small class="text-muted">History of past attendance modification requests and admin responses</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Requested Time</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Admin Remark</th>
                                <th>Requested At</th>
                                <th class="pe-4">Reviewed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($verificationHistory as $verification)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">#{{ $verification->verification_id ?? $verification->id }}</td>
                                    <td class="fw-semibold text-secondary">
                                        {{ $verification->attendance ? \Carbon\Carbon::parse($verification->attendance->attendance_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1 small">
                                            {{ $verification->request_type === 'time_in' ? 'Missed Time In' : 'Missed Time Out' }}
                                        </span>
                                    </td>
                                    <td class="fw-semibold text-dark">
                                        {{ \Carbon\Carbon::parse($verification->requested_time)->format('h:i A') }}
                                    </td>
                                    <td class="text-muted small" style="max-width: 200px;">{{ $verification->reason }}</td>
                                    <td>
                                        @if(strtolower($verification->status) === 'approved')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-semibold">Approved</span>
                                        @elseif(strtolower($verification->status) === 'rejected')
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 fw-semibold">Rejected</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1 fw-semibold">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $verification->admin_remark ?? '-' }}</td>
                                    <td class="text-muted small">
                                        {{ $verification->requested_at ? \Carbon\Carbon::parse($verification->requested_at)->format('d M Y, h:i A') : '-' }}
                                    </td>
                                    <td class="pe-4 text-muted small">
                                        {{ $verification->reviewed_at ? \Carbon\Carbon::parse($verification->reviewed_at)->format('d M Y, h:i A') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        No verification requests found.
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