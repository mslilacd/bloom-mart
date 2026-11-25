<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User Records - Bloom Mart</title>

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
                <span class="text-muted fw-semibold">| User Registration</span>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="container pb-5" style="max-width: 720px;">

        <!-- Page Header -->
        <div class="mb-4 text-center">
            <h2 class="fw-extrabold mb-1">Register New User</h2>
            <p class="text-muted small mb-0">Create new staff accounts for assistants or admins to grant system access.</p>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Validation Error Alerts --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-octagon-fill text-danger fs-5"></i>
                    <strong class="text-danger">Please correct the following errors:</strong>
                </div>
                <ul class="mb-0 ps-4 text-danger small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Registration Form Card --}}
        <div class="saas-card p-4 p-md-5">
            <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-3">
                <i class="bi bi-person-plus-fill text-primary fs-4"></i>
                <div>
                    <h5 class="fw-bold mb-0">Account Information</h5>
                    <small class="text-muted">Fill in user details to generate access credentials</small>
                </div>
            </div>

            <form action="{{ url('/admin/users/store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    
                    <!-- Full Name -->
                    <div class="col-12">
                        <label for="name" class="form-label fw-semibold small text-secondary">FULL NAME *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" id="name" class="form-control border-start-0" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                        </div>
                    </div>

                    <!-- IC Number -->
                    <div class="col-md-6">
                        <label for="ic_number" class="form-label fw-semibold small text-secondary">IC NUMBER *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="bi bi-card-heading"></i></span>
                            <input type="text" name="ic_number" id="ic_number" class="form-control border-start-0" value="{{ old('ic_number') }}" placeholder="e.g. 010203040506" required>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold small text-secondary">EMAIL ADDRESS *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0" value="{{ old('email') }}" placeholder="e.g. user@example.com" required>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold small text-secondary">PHONE NUMBER</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="phone" id="phone" class="form-control border-start-0" value="{{ old('phone') }}" placeholder="e.g. +60123456789">
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="col-md-6">
                        <label for="role" class="form-label fw-semibold small text-secondary">ROLE *</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="assistant" {{ old('role') === 'assistant' ? 'selected' : '' }}>Assistant</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-6">
                        <label for="start_date" class="form-label fw-semibold small text-secondary">START DATE</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                    </div>

                    <!-- Password -->
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold small text-secondary">PASSWORD *</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0" placeholder="Minimum 6 characters" required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 pt-3">
                        <button type="submit" class="btn btn-saas btn-lg w-100 py-2">
                            <i class="bi bi-person-check-fill me-2"></i> Register User
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>