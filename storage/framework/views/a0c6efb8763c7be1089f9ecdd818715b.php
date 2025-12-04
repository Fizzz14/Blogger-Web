<?php $__env->startSection('title', 'Trashed Articles'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2 gradient-text">
            <i class="bi bi-trash me-2"></i>Trashed Articles
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-2"></i>Back to Articles
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-ul me-2"></i>Deleted Articles
            </h5>
        </div>
        <div class="card-body">
            <?php if($articles->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e(Str::limit($article->title, 50)); ?></strong>
                                        <?php if($article->featured_image): ?>
                                            <i class="bi bi-image text-primary ms-1" title="Has featured image"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($article->category): ?>
                                            <span class="badge" style="background-color: <?php echo e($article->category->color); ?>;">
                                                <?php echo e($article->category->name); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">No category</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($article->user): ?>
                                            <?php echo e($article->user->name); ?>

                                        <?php else: ?>
                                            <span class="text-muted">Unknown</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($article->deleted_at->diffForHumans()); ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="<?php echo e(route('articles.restore', $article->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm rounded-pill me-2" title="Restore">
                                                    <i class="bi bi-arrow-clockwise"></i> Restore
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('articles.forceDelete', $article->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Are you sure you want to permanently delete this article? This action cannot be undone.')" title="Delete Permanently">
                                                    <i class="bi bi-trash"></i> Delete 
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
                <div class="text-center py-5">
                    <i class="bi bi-trash display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No Trashed Articles</h4>
                    <p class="text-muted">Your trash is empty. Articles you delete will appear here.</p>
                    <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Articles
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\articles\trash.blade.php ENDPATH**/ ?>