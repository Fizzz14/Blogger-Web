<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-people me-2"></i>User Management
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('users.create-staff')); ?>" class="btn btn-primary">
            <i class="bi bi-person-plus me-2"></i>Add Staff
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Users</h5>
        <div class="d-flex">
            <div class="input-group me-2">
                <input type="text" id="search-users" class="form-control" placeholder="Search users...">
                <button class="btn btn-outline-secondary" type="button" id="clear-search">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <select id="role-filter" class="form-select">
                <option value="">All Roles</option>
                <option value="user">Users</option>
                <option value="staff">Staff</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <?php if($users->count() > 0): ?>
            <div class="table-responsive">
                <table class="table" id="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Articles</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-role="<?php echo e($user->role); ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo e($user->getAvatarUrl()); ?>" alt="Avatar"
                                         class="rounded-circle me-2" width="32" height="32">
                                    <div>
                                        <div><?php echo e($user->name); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <?php if($user->role === 'admin'): ?>
                                    <span class="badge bg-danger">Admin</span>
                                <?php elseif($user->role === 'staff'): ?>
                                    <span class="badge bg-warning">Staff</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">User</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-info"><?php echo e($user->articles_count); ?></span>
                            </td>
                            <td><?php echo e($user->created_at->format('M d, Y')); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <?php if(auth()->user()->role === 'admin' || $user->role !== 'admin'): ?>
                                    <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-warning me-2 rounded-pill" title="Edit User">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <?php endif; ?>
                                    <?php if($user->role !== 'admin'): ?>
                                    <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure you want to delete this user?')" title="Delete User">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="bi bi-people display-4 text-muted mb-3"></i>
                <p class="text-muted">No users found. Add your first staff member!</p>
                <a href="<?php echo e(route('users.create-staff')); ?>" class="btn btn-primary">
                    <i class="bi bi-person-plus me-2"></i>Add Staff
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('search-users');
        const clearButton = document.getElementById('clear-search');
        const roleFilter = document.getElementById('role-filter');
        const tableRows = document.querySelectorAll('#users-table tbody tr');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const name = row.querySelector('td:first-child').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        });

        // Role filter functionality
        roleFilter.addEventListener('change', function() {
            const selectedRole = this.value;

            tableRows.forEach(row => {
                if (selectedRole === '' || row.dataset.role === selectedRole) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\users\index.blade.php ENDPATH**/ ?>