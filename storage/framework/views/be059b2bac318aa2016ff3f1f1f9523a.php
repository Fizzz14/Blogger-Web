<?php $__env->startSection('title', 'My Articles'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2 gradient-text">
            <i class="bi bi-journal-text me-2"></i>My Articles
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo e(route('articles.create')); ?>" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-2"></i>New Article
            </a>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo e(route('articles.export')); ?>">Export as Excel</a></li>
                </ul>
            </div>
            <div class="btn-group me-2">
                </button>
                <ul class="dropdown-menu">
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
            <a href="<?php echo e(route('articles.trash')); ?>" class="btn btn-outline-secondary">
                <i class="bi bi-trash me-2"></i>Trash
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-ul me-2"></i>Articles List
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
                                <th>Status</th>
                                <th>Views</th>
                                <th>Likes</th>
                                <th>Created</th>
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
                                        <span class="badge" style="background-color: <?php echo e($article->category->color); ?>;">
                                            <?php echo e($article->category->name); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-<?php echo e($article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($article->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <i class="bi bi-eye me-1"></i><?php echo e($article->view_count); ?>

                                    </td>
                                    <td>
                                        <i class="bi bi-heart me-1"></i><?php echo e($article->like_count); ?>

                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo e($article->created_at->diffForHumans()); ?></small>
                                    </td>
                                    <td>
                                            <a href="<?php echo e(route('articles.edit', $article)); ?>"
                                               class="btn btn-warning me-2 rounded-pill" title="Edit">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="<?php echo e(route('articles.destroy', $article)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure you want to delete this')" title="Delete User">
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
                    <i class="bi bi-journal-text display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No Articles Yet</h4>
                    <p class="text-muted">Start writing your first article and share your thoughts with the world.</p>
                    <a href="<?php echo e(route('articles.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create Your First Article
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views/articles/index.blade.php ENDPATH**/ ?>