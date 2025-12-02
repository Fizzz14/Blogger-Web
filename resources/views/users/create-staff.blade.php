@extends('template.app')

@section('title', 'Add Staff Member')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-person-plus me-2"></i>Add Staff Member
    </h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Users
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Staff Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store-staff') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                       id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Add Staff Member
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>Staff Information
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="bi bi-shield-check me-2"></i>Staff Permissions:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Create, edit, and publish articles</li>
                        <li>Manage categories</li>
                        <li>View dashboard statistics</li>
                        <li>Cannot manage users (Admin only)</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="bi bi-key me-2"></i>Security Note:</h6>
                    <p class="mb-0">Staff members can create and manage content, but cannot access user management functions or system settings.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
