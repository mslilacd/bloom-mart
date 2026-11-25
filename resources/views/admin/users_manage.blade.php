<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Registration Records - Bloom Mart</title>

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
                <span class="text-muted fw-semibold">| User Management</span>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="container pb-5">

        <!-- Page Header & Title -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
            <div>
                <h2 class="fw-extrabold mb-1">Manage Registration Records</h2>
                <p class="text-muted small mb-0">Search, monitor active store assistant accounts, and manage system access.</p>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Search Form Card --}}
        <div class="saas-card p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-search text-primary fs-5"></i>
                <h5 class="fw-bold mb-0">Search Records</h5>
            </div>

            <form method="GET" action="{{ url('/admin/manage-users') }}" class="row g-3 align-items-end">
                <div class="col-md-8 col-lg-9">
                    <label for="search" class="form-label fw-semibold small text-secondary">SEARCH STORE ASSISTANT</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white text-muted"><i class="bi bi-person-search"></i></span>
                        <input type="text" name="search" id="search" class="form-control border-start-0" value="{{ $search }}" placeholder="Enter name, user ID, or IC number">
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 d-flex gap-2">
                    <button type="submit" class="btn btn-saas w-100">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                    <a href="{{ url('/admin/manage-users') }}" class="btn btn-outline-secondary px-4">Reset</a>
                </div>
            </form>
        </div>

        {{-- User Records Table Card --}}
        <div class="saas-card p-0 overflow-hidden">
            <div class="p-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0">Registered Assistant Records</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4">User ID</th>
                            <th>Name</th>
                            <th>IC Number</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th class="pe-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#{{ $user->user_id }}</td>
                                <td class="fw-bold text-dark">{{ $user->name }}</td>
                                <td><code class="text-dark">{{ $user->ic_number ?? '-' }}</code></td>
                                <td><a href="mailto:{{ $user->email }}" class="text-decoration-none text-muted">{{ $user->email }}</a></td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-semibold px-2 py-1">
                                        {{ strtoupper($user->type ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>
                                    {{ !empty($user->start_date) ? date('d M Y', strtotime($user->start_date)) : '-' }}
                                </td>
                                <td>
                                    @if(strtolower($user->status ?? '') === 'active')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-semibold">Active</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1 fw-semibold">{{ ucfirst($user->status ?? 'Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ url('/admin/users/' . $user->user_id . '/edit') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>

                                        @if(strtolower($user->status ?? '') === 'active')
                                            <form action="{{ url('/admin/users/' . $user->user_id . '/deactivate') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Are you sure you want to deactivate this account?');">
                                                    <i class="bi bi-person-x me-1"></i> Deactivate
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small align-self-center">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-person-slash fs-2 d-block mb-2"></i>
                                    No Store Assistant records found matching your search criteria.
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