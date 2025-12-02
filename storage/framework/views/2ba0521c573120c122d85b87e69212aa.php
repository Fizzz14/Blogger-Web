

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                        <i class="bi bi-house me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('articles.*') ? 'active' : ''); ?>" href="<?php echo e(route('articles.index')); ?>">
                        <i class="bi bi-journal-text me-2"></i> Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('categories.index')); ?>">
                        <i class="bi bi-tags me-2"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('admin.comments.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.comments.index')); ?>">
                        <i class="bi bi-chat-left-text me-2"></i> Comments
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>User Management</span>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                        <i class="bi bi-people me-2"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('users.create-staff') ? 'active' : ''); ?>" href="<?php echo e(route('users.create-staff')); ?>">
                        <i class="bi bi-person-plus me-2"></i> Add Staff
                    </a>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Account</span>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>" href="<?php echo e(route('profile.edit')); ?>">
                        <i class="bi bi-person-circle me-2"></i> My Profile
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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

        <?php echo $__env->yieldContent('admin_content'); ?>
    </main>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\template\admin.blade.php ENDPATH**/ ?>