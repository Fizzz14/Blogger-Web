@extends('template.app')

@section('content')
<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-house me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('articles.*') ? 'active' : '' }}" href="{{ route('articles.index') }}">
                        <i class="bi bi-journal-text me-2"></i> Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <i class="bi bi-tags me-2"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                        <i class="bi bi-chat-left-text me-2"></i> Comments
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>User Management</span>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="bi bi-people me-2"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.create-staff') ? 'active' : '' }}" href="{{ route('users.create-staff') }}">
                        <i class="bi bi-person-plus me-2"></i> Add Staff
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('admin_content')
    </main>
</div>
@endsection
