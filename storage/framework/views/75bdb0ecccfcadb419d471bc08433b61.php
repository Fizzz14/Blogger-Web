

<?php $__env->startSection('title', $article->title); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Article Card -->
        <div class="card mb-4 shadow-sm">
            <!-- Article Header -->
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e($article->user->getAvatarUrl()); ?>" alt="<?php echo e($article->user->name); ?>"
                             class="rounded-circle me-3" width="40" height="40">
                        <div>
                            <h6 class="mb-0 fw-bold"><?php echo e($article->user->name); ?></h6>
                            <small class="text-muted"><?php echo e($article->published_at ? $article->published_at->format('M d, Y') : 'Not published'); ?> · <?php echo e($article->category->name); ?></small>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-<?php echo e($article->status === 'published' ? 'success' : 'secondary'); ?>">
                            <?php echo e($article->status); ?>

                        </span>
                    </div>
                </div>
            </div>

            <!-- Article Title -->
            <div class="px-3 pt-2">
                <h4 class="fw-bold"><?php echo e($article->title); ?></h4>
                <?php if($article->excerpt): ?>
                <p class="text-muted"><?php echo e($article->excerpt); ?></p>
                <?php endif; ?>
            </div>

            <!-- Featured Image -->
            <?php if($article->featured_image): ?>
            <div class="card-body p-0">
                <img src="<?php echo e(Storage::url($article->featured_image)); ?>" alt="<?php echo e($article->title); ?>"
                     class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
            </div>
            <?php endif; ?>

            <!-- Article Stats -->
            <div class="card-body pt-3 pb-2">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="me-3"><i class="bi bi-eye"></i> <?php echo e($article->view_count); ?> views</span>
                        <span class="me-3"><i class="bi bi-heart"></i> <?php echo e($article->like_count); ?> likes</span>
                        <span><i class="bi bi-chat"></i> <?php echo e($article->comments->count()); ?> comments</span>
                    </div>
                    <div>
                        <a href="<?php echo e(route('articles.edit', $article)); ?>" class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="card-body pt-0">
                <div class="article-content">
                    <?php echo nl2br(e($article->content)); ?>

                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Comments (<?php echo e($article->comments->count()); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if($article->comments->count() > 0): ?>
                    <?php $__currentLoopData = $article->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="comment mb-3 pb-3 border-bottom">
                            <div class="d-flex">
                                <img src="<?php echo e($comment->user->getAvatarUrl()); ?>"
                                     alt="<?php echo e($comment->user->name); ?>"
                                     class="rounded-circle me-2" width="32" height="32">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 fw-bold"><?php echo e($comment->user->name); ?></h6>
                                        <small class="text-muted"><?php echo e($comment->created_at->diffForHumans()); ?></small>
                                    </div>
                                    <p class="mb-0 mt-1"><?php echo e($comment->content); ?></p>

                                    <!-- Comment Actions -->
                                    <div class="mt-2">
                                        <a href="<?php echo e(route('staff.comments.show', $comment)); ?>" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                        <a href="<?php echo e(route('staff.comments.edit', $comment)); ?>" class="btn btn-sm btn-outline-secondary">
                                            Edit
                                        </a>
                                        <form action="<?php echo e(route('comments.destroy', $comment)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted">No comments yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Article Actions -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Article Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('articles.edit', $article)); ?>" class="btn btn-primary">
                        Edit Article
                    </a>

                    <?php if($article->status === 'published'): ?>
                        <a href="#" class="btn btn-warning">
                            Unpublish
                        </a>
                    <?php else: ?>
                        <a href="#" class="btn btn-success">
                            Publish
                        </a>
                    <?php endif; ?>

                    <form action="<?php echo e(route('articles.destroy', $article)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this article?')">
                            Delete Article
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Article Details -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Article Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td class="text-muted">ID:</td>
                        <td><?php echo e($article->id); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Slug:</td>
                        <td><?php echo e($article->slug); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status:</td>
                        <td>
                            <span class="badge bg-<?php echo e($article->status === 'published' ? 'success' : 'secondary'); ?>">
                                <?php echo e($article->status); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Category:</td>
                        <td><?php echo e($article->category->name); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Author:</td>
                        <td><?php echo e($article->user->name); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created:</td>
                        <td><?php echo e($article->created_at->format('M d, Y')); ?></td>
                    </tr>
                    <?php if($article->published_at): ?>
                    <tr>
                        <td class="text-muted">Published:</td>
                        <td><?php echo e($article->published_at->format('M d, Y')); ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="text-muted">Views:</td>
                        <td><?php echo e($article->view_count); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Likes:</td>
                        <td><?php echo e($article->like_count); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\articles\show.blade.php ENDPATH**/ ?>