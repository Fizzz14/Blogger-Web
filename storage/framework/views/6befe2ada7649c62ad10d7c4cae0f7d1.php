<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Bacakuy'); ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-bg: #ffffff;
            --darker-bg: #f8f9fa;
            --card-bg: #ffffff;
            --border-color: #dee2e6;
            --text-primary: #212529;
            --text-secondary: #6c757d;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .navbar-light {
            background: linear-gradient(135deg, var(--darker-bg) 0%, var(--dark-bg) 100%) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar {
            background: linear-gradient(180deg, var(--darker-bg) 0%, var(--dark-bg) 100%);
            border-right: 1px solid var(--border-color);
            min-height: calc(100vh - 56px);
        }

        .sidebar .nav-link {
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            margin: 0.125rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 0.5rem;
        }

        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .table-dark {
            --bs-table-bg: var(--card-bg);
            --bs-table-border-color: var(--border-color);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4f46e5 100%);
            border: none;
            border-radius: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .form-control {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 0.5rem;
        }

        .form-control:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .alert {
            border: none;
            border-radius: 0.75rem;
        }

        .badge {
            border-radius: 0.375rem;
        }

        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .article-card {
            transition: all 0.3s ease;
        }

        .article-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .gradient-text {
            background: #000000;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold gradient-text d-flex align-items-center" href="<?php echo e(route('dashboard')); ?>">
                <img src="<?php echo e(asset('Image/buku.png')); ?>" alt="Bacakuy" class="me-2"
                    style="height: 30px; width: auto;">
                Bacakuy
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
                            href="<?php echo e(route('dashboard')); ?>">
                            <i class="bi bi-house"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        <!-- User Info dengan Role Badge -->
                        <li class="nav-item">
                            <div class="navbar-text me-3">
                                <img src="<?php echo e(auth()->user()->getAvatarUrl()); ?>" alt="Avatar" class="rounded-circle me-2"
                                    width="32" height="32">
                                <span class="d-none d-md-inline">
                                    <strong><?php echo e(auth()->user()->name); ?></strong>
                                    <?php if(auth()->user()->isAdmin()): ?>
                                        <span class="badge bg-danger ms-1">Admin</span>
                                    <?php elseif(auth()->user()->isStaff()): ?>
                                        <span class="badge bg-warning ms-1">Staff</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary ms-1">User</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="nav-link p-0 me-2" title="My Profile">
                                <img src="<?php echo e(auth()->user()->getAvatarUrl()); ?>" alt="Profile" class="rounded-circle"
                                    width="36" height="36">
                            </a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-secondary btn-sm" title="Logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li><button class="dropdown-item" type="button">
                                <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </a>
                            </button>
                        </li>
                        <li><button class="dropdown-item" type="button">
                                <a class="nav-link" href="<?php echo e(route('register')); ?>">
                                    <i class="bi bi-person-plus"></i> Register
                                </a>
                            </button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            </ul>
        </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <!-- Page Content -->
        <main class="col-12 px-md-4 py-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fix dropdown z-index and ensure proper Bootstrap functionality
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Bootstrap dropdowns
            const dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'))
            const dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });

            // Fix dropdown styling
            const dropdowns = document.querySelectorAll(".dropdown-menu");
            dropdowns.forEach(dropdown => {
                dropdown.style.zIndex = "9999";
                dropdown.style.backgroundColor = "var(--card-bg)";
                dropdown.style.border = "1px solid var(--border-color)";
                dropdown.style.boxShadow = "0 4px 6px -1px rgba(0, 0, 0, 0.1)";
                dropdown.style.borderRadius = "0.5rem";
                dropdown.style.padding = "0.5rem 0";
                dropdown.style.marginTop = "0.5rem";
            });
        });
    </script>

    <!-- Custom JS -->
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Confirm before delete
        function confirmDelete(message = 'Are you sure you want to delete this item?') {
            return confirm(message);
        }
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <!-- JavaScript untuk dropdown sudah ditangani di atas -->
</body>

</html>
<?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views/template/app.blade.php ENDPATH**/ ?>