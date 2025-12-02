

<?php $__env->startSection('title', 'Edit Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        Edit Category
    </h1>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?php echo e(route('categories.update', $category)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $category->name)); ?>" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <div class="input-group">
                            <input type="text" class="form-control <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="color" name="color" value="<?php echo e(old('color', $category->color)); ?>" required>
                            <input type="color" class="form-control form-control-color" id="colorPicker" value="<?php echo e(old('color', $category->color)); ?>" title="Choose a color">
                        </div>
                        <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">Choose a color to represent this category</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description" rows="3"><?php echo e(old('description', $category->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-outline-secondary">
                            Back to Categories
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Preview
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Category Badge Preview</label>
                    <div class="p-3 border rounded">
                        <span class="badge fs-5 p-2" id="previewBadge" style="background-color: <?php echo e($category->color); ?>;">
                            <?php echo e($category->name); ?>

                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Article Card Preview</label>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sample Article Title</h5>
                            <div class="mb-2">
                                <span class="badge" id="articleBadge" style="background-color: <?php echo e($category->color); ?>;">
                                    <?php echo e($category->name); ?>

                                </span>
                            </div>
                            <p class="card-text">This is how your category will appear on article cards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('previewBadge').textContent = this.value || 'Category Name';
        document.getElementById('articleBadge').textContent = this.value || 'Category Name';
    });

    document.getElementById('color').addEventListener('input', function() {
        const color = this.value;
        document.getElementById('colorPicker').value = color;
        document.getElementById('previewBadge').style.backgroundColor = color;
        document.getElementById('articleBadge').style.backgroundColor = color;
    });

    document.getElementById('colorPicker').addEventListener('input', function() {
        const color = this.value;
        document.getElementById('color').value = color;
        document.getElementById('previewBadge').style.backgroundColor = color;
        document.getElementById('articleBadge').style.backgroundColor = color;
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\categories\edit.blade.php ENDPATH**/ ?>