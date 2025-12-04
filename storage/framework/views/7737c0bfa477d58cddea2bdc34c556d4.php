<?php $__env->startSection('title', 'Manage Categories - Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-tags me-2"></i>Categories
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>New Category
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Categories</h5>
        <div>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo e(route('categories.export')); ?>">Export as Excel</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-arrow-up me-1"></i>Import
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo e(asset('storage/templates/categories_import_template.xlsx')); ?>" download>Download Template</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="<?php echo e(route('categories.import')); ?>" method="POST" enctype="multipart/form-data" class="p-2">
                            <?php echo csrf_field(); ?>
                            <div class="mb-2">
                                <label for="file" class="form-label">Choose Excel File</label>
                                <input class="form-control form-control-sm" type="file" name="file" id="file" required accept=".xlsx,.xls,.csv">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary w-100">Import</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if($categories->count() > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Color</th>
                            <th>Articles</th>
                            <th>Description</th>
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
                                <code class="ms-2"><?php echo e($category->color); ?></code>
                            </td>
                            <td>
                                <span class="badge bg-info"><?php echo e($category->articles_count); ?></span>
                            </td>
                            <td><?php echo e(Str::limit($category->description, 50)); ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('categories.edit', $category)); ?>" class="">
                                        <i class=""></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="" onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class=""></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="bi bi-tags display-4 text-muted mb-3"></i>
                <p class="text-muted">No categories yet. Create your first category!</p>
                <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create Category
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\staff\categories\index.blade.php ENDPATH**/ ?>