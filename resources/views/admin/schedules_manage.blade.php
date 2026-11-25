<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedule - Bloom Mart</title>

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
                <span class="text-muted fw-semibold">| Schedule Management</span>
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
                <h2 class="fw-extrabold mb-1">Manage Schedules</h2>
                <p class="text-muted small mb-0">Assign work shifts, track assistant timings, and adjust store coverage.</p>
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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-octagon-fill text-danger fs-5"></i>
                    <strong class="text-danger">Please correct the following errors:</strong>
                </div>
                <ul class="mb-0 ps-4 text-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Create Schedule Form Card --}}
        <div class="saas-card p-4 mb-5">
            <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-3">
                <i class="bi bi-calendar-plus-fill text-primary fs-4"></i>
                <div>
                    <h5 class="fw-bold mb-0">Create Schedule</h5>
                    <small class="text-muted">Assign a new shift and timing to a store assistant</small>
                </div>
            </div>

            <form method="POST" action="{{ url('/admin/schedules') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="user_id" class="form-label fw-semibold small text-secondary">STORE ASSISTANT *</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>-- Select Store Assistant --</option>
                            @foreach($assistants as $assistant)
                                @php
                                    $assistantId = $assistant->user_id ?? $assistant->id;
                                @endphp
                                <option value="{{ $assistantId }}" {{ old('user_id') == $assistantId ? 'selected' : '' }}>
                                    {{ $assistant->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="schedule_date" class="form-label fw-semibold small text-secondary">SCHEDULE DATE *</label>
                        <input type="date" name="schedule_date" id="schedule_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ old('schedule_date') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="shift" class="form-label fw-semibold small text-secondary">SHIFT *</label>
                        <select name="shift" id="shift" class="form-select" required>
                            <option value="">Select Shift</option>
                            <option value="Morning" {{ old('shift') === 'Morning' ? 'selected' : '' }}>Morning</option>
                            <option value="Afternoon" {{ old('shift') === 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                            <option value="Evening" {{ old('shift') === 'Evening' ? 'selected' : '' }}>Evening</option>
                            <option value="Full Day" {{ old('shift') === 'Full Day' ? 'selected' : '' }}>Full Day</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="start_time" class="form-label fw-semibold small text-secondary">START TIME *</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="end_time" class="form-label fw-semibold small text-secondary">END TIME *</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold small text-secondary">SCHEDULE DESCRIPTION</label>
                        <textarea name="description" id="description" class="form-control" rows="2" maxlength="255" placeholder="Example: Morning cashier duty">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-12 text-end pt-3">
                        <button type="submit" class="btn btn-saas px-4">
                            <i class="bi bi-plus-lg me-1"></i> Create Schedule
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Schedule Records Table --}}
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-table text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0">Schedule Records</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4">Schedule ID</th>
                            <th>Store Assistant</th>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>Description</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th class="pe-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#{{ $schedule->schedule_id }}</td>
                                <td class="fw-bold text-dark">{{ $schedule->user->name ?? 'N/A' }}</td>
                                <td>{{ date('d M Y', strtotime($schedule->schedule_date)) }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-semibold">
                                        {{ $schedule->shift }}
                                    </span>
                                </td>
                                <td class="text-muted small">{{ !empty($schedule->description) ? $schedule->description : '-' }}</td>
                                <td class="text-success fw-semibold">{{ date('h:i A', strtotime($schedule->start_time)) }}</td>
                                <td class="text-danger fw-semibold">{{ date('h:i A', strtotime($schedule->end_time)) }}</td>
                                <td class="pe-4 text-center">
                                    <form action="{{ url('/admin/schedules/' . $schedule->schedule_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Are you sure you want to delete this schedule?');">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                    No schedule records found.
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