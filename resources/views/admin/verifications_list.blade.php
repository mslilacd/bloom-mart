<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Verification Requests - Bloom Mart</title>

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
                <span class="text-muted fw-semibold">| Attendance Verification</span>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="container pb-5">

        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
            <div>
                <h2 class="fw-extrabold mb-1">Attendance Verification Requests</h2>
                <p class="text-muted small mb-0">Review pending assistant check-in/out verification submissions and inspect past actions.</p>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Section 1: Pending Requests Card --}}
        <div class="saas-card p-0 overflow-hidden mb-5">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-hourglass-split text-warning fs-4"></i>
                    <div>
                        <h5 class="fw-bold mb-0">Pending Requests</h5>
                        <small class="text-muted">Awaiting administrative approval</small>
                    </div>
                </div>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1 fw-bold fs-6">
                    {{ $pendingRequests->count() }}
                </span>
            </div>

            <div class="card-body p-0">
                @if($pendingRequests->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-check2-all fs-2 d-block mb-2 text-success"></i>
                        No pending verification requests at the moment.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4">User</th>
                                    <th>Attendance Date</th>
                                    <th>Type</th>
                                    <th>Requested Time</th>
                                    <th>Reason / Explanation</th>
                                    <th>Submitted At</th>
                                    <th class="pe-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingRequests as $request)
                                    <tr>
                                        <td class="ps-4">
                                            <strong class="text-dark d-block">{{ $request->user->name ?? 'N/A' }}</strong>
                                            <small class="text-muted">{{ $request->user->email ?? '' }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-secondary">{{ $request->attendance->attendance_date ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-1 fw-semibold">
                                                {{ strtoupper(str_replace('_', ' ', $request->request_type)) }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-dark">{{ $request->requested_time }}</td>
                                        <td class="text-muted small" style="max-width: 250px;">{{ $request->reason ?? 'No reason provided' }}</td>
                                        <td class="text-muted small">{{ $request->requested_at }}</td>
                                        <td class="pe-4 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Approve Form --}}
                                                <form action="{{ url('/admin/verifications/' . $request->verification_id . '/approve') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="admin_remark" value="Approved by Admin">
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Approve this request?')">
                                                        <i class="bi bi-check-lg me-1"></i> Approve
                                                    </button>
                                                </form>

                                                {{-- Reject Modal Trigger Button --}}
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->verification_id }}">
                                                    <i class="bi bi-x-lg me-1"></i> Reject
                                                </button>
                                            </div>

                                            {{-- Reject Modal --}}
                                            <div class="modal fade" id="rejectModal{{ $request->verification_id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $request->verification_id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content text-start border-0 shadow">
                                                        <form action="{{ url('/admin/verifications/' . $request->verification_id . '/reject') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header border-bottom-0 pb-0">
                                                                <h5 class="modal-title fw-bold text-danger" id="rejectModalLabel{{ $request->verification_id }}">
                                                                    <i class="bi bi-exclamation-octagon-fill me-2"></i> Reject Verification Request
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body py-3">
                                                                <div class="mb-3">
                                                                    <label for="admin_remark_{{ $request->verification_id }}" class="form-label fw-semibold small text-secondary">
                                                                        REJECTION REMARK <span class="text-danger">*</span>
                                                                    </label>
                                                                    <textarea name="admin_remark" id="admin_remark_{{ $request->verification_id }}" class="form-control" rows="3" required placeholder="Please enter a reason for rejecting this request..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-top-0 pt-0">
                                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger rounded-pill px-4">Confirm Rejection</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Section 2: Processed Requests History Card --}}
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-secondary fs-4"></i>
                    <div>
                        <h5 class="fw-bold mb-0">Processed History</h5>
                        <small class="text-muted">Approved and rejected verification records</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if($processedRequests->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        No processed history found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4">User</th>
                                    <th>Attendance Date</th>
                                    <th>Type</th>
                                    <th>Requested Time</th>
                                    <th>Status</th>
                                    <th>Admin Remark</th>
                                    <th class="pe-4">Reviewed At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($processedRequests as $request)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $request->user->name ?? 'N/A' }}</td>
                                        <td class="text-secondary fw-semibold">{{ $request->attendance->attendance_date ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border px-2 py-1 small">
                                                {{ strtoupper(str_replace('_', ' ', $request->request_type)) }}
                                            </span>
                                        </td>
                                        <td class="fw-semibold text-dark">{{ $request->requested_time }}</td>
                                        <td>
                                            @if($request->status === 'approved')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-semibold">Approved</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 fw-semibold">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="text-muted small">{{ $request->admin_remark ?? '-' }}</td>
                                        <td class="pe-4 text-muted small">{{ $request->reviewed_at ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>