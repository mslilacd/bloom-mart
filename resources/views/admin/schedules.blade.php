<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedules - Bloom Mart</title>

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
                <span class="text-muted fw-semibold">| Shift Assignment</span>
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
                <h2 class="fw-extrabold mb-1">Assign Shift Schedule</h2>
                <p class="text-muted small mb-0">Create new shift assignments and manage assistant work schedules.</p>
            </div>
        </div>

        {{-- Success Message Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Assign Shift Form Card --}}
        <div class="saas-card p-4 mb-5">
            <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-3">
                <i class="bi bi-calendar-check-fill text-primary fs-4"></i>
                <div>
                    <h5 class="fw-bold mb-0">Assign Shift</h5>
                    <small class="text-muted">Fill in details to assign a work shift to a store assistant</small>
                </div>
            </div>

            <form method="POST" action="{{ url('/admin/schedules') }}">
                @csrf

                <div class="row g-3">
                    
                    <!-- Assistant Selection -->
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label fw-semibold small text-secondary">ASSISTANT *</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">Select Assistant</option>
                            @foreach ($assistants as $assistant)
                                <option value="{{ $assistant->user_id }}">{{ $assistant->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Shift Date -->
                    <div class="col-md-6 col-lg-4">
                        <label class="form-label fw-semibold small text-secondary">SHIFT DATE *</label>
                        <input type="date" name="shift_date" class="form-control" required>
                    </div>

                    <!-- Start & End Time -->
                    <div class="col-md-6 col-lg-2">
                        <label class="form-label fw-semibold small text-secondary">START TIME *</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="col-md-6 col-lg-2">
                        <label class="form-label fw-semibold small text-secondary">END TIME *</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>

                    <!-- Task / Notes -->
                    <div class="col-12">
                        <label class="form-label fw-semibold small text-secondary">TASK / NOTES</label>
                        <input type="text" name="task_notes" class="form-control" placeholder="Optional notes...">
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end pt-3">
                        <button type="submit" class="btn btn-saas px-4">
                            <i class="bi bi-plus-circle me-1"></i> Assign Shift
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- All Schedules Table Card --}}
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0">All Schedules</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Assistant Name</th>
                            <th>Shift Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Tasks</th>
                            <th class="pe-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules as $schedule)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#{{ $schedule->schedule_id }}</td>
                                <td class="fw-bold text-dark">{{ $schedule->user->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->shift_date)->format('d M Y') }}</td>
                                <td class="text-success fw-semibold">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                </td>
                                <td class="text-danger fw-semibold">
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                </td>
                                <td class="text-muted small">{{ $schedule->task_notes ?? '-' }}</td>
                                <td class="pe-4 text-center">
                                    <form method="POST" action="{{ url('/admin/schedules/' . $schedule->schedule_id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Delete shift?');">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                    No schedules assigned yet.
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