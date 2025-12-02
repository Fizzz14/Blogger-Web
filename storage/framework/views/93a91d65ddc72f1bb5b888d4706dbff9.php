

<?php $__env->startSection('title', 'Manage Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        Categories
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">
            New Category
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Categories</h5>
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" id="toggle-view">
                Grid
            </button>
            <button type="button" class="btn btn-outline-secondary active" id="toggle-table">
                List
            </button>
        </div>
    </div>
    <div class="card-body">
        <?php if($categories->count() > 0): ?>
            <div class="table-responsive" id="table-view">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Articles Count</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <span class="badge" style="background-color: <?php echo e($category->color); ?>;">
                                        <?php echo e($category->name); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="d-inline-block" style="width: 20px; height: 20px; background-color: <?php echo e($category->color); ?>; border-radius: 4px;"></span>
                                    <span class="ms-2 text-muted"><?php echo e($category->color); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($category->articles_count); ?></span>
                                </td>
                                <td>
                                    <small class="text-muted"><?php echo e($category->created_at->diffForHumans()); ?></small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo e(route('categories.edit', $category)); ?>"
                                           class="btn btn-warning me-2 rounded-pill" title="Edit">
                                            Edit
                                        </a>
                                        <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger rounded-pill" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="row g-3 d-none" id="grid-view">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge fs-6 p-2" style="background-color: <?php echo e($category->color); ?>;">
                                        <?php echo e($category->name); ?>

                                    </span>
                                    <span class="badge bg-info ms-auto"><?php echo e($category->articles_count); ?> articles</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="d-inline-block me-2" style="width: 16px; height: 16px; background-color: <?php echo e($category->color); ?>; border-radius: 4px;"></span>
                                    <small class="text-muted"><?php echo e($category->color); ?></small>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted"><?php echo e($category->created_at->diffForHumans()); ?></small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="btn-group btn-group-sm w-100">
                                    <a href="<?php echo e(route('categories.edit', $category)); ?>"
                                       class="btn btn-warning me-2 rounded-pill">
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger rounded-pill"
                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <h4 class="text-muted mt-3">No Categories Yet</h4>
                <p class="text-muted">Create your first category to organize your articles.</p>
                <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">
                    Create First Category
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('toggle-view').addEventListener('click', function() {
        document.getElementById('table-view').classList.add('d-none');
        document.getElementById('grid-view').classList.remove('d-none');
        this.classList.add('active');
        document.getElementById('toggle-table').classList.remove('active');
    });

    document.getElementById('toggle-table').addEventListener('click', function() {
        document.getElementById('grid-view').classList.add('d-none');
        document.getElementById('table-view').classList.remove('d-none');
        this.classList.add('active');
        document.getElementById('toggle-view').classList.remove('active');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\categories\index.blade.php ENDPATH**/ ?>