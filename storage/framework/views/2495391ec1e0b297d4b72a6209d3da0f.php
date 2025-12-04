<?php $__env->startSection('title', 'Comment Details'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Main Comment -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Comment Details</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('admin.comments.index')); ?>" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="comment mb-4">
                        <div class="d-flex">
                            <img src="<?php echo e($comment->user->getAvatarUrl()); ?>" alt="<?php echo e($comment->user->name); ?>"
                                 class="rounded-circle me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5><?php echo e($comment->user->name); ?></h5>
                                        <small class="text-muted"><?php echo e($comment->created_at->format('M d, Y H:i')); ?></small>
                                        <?php if($comment->parent): ?>
                                            <div class="mt-1">
                                                <small class="text-info">Replying to comment by <?php echo e($comment->parent->user->name); ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php if($comment->is_approved): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-3 p-3 bg-light rounded">
                                    <?php echo e($comment->content); ?>

                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        On article: <a href="<?php echo e(route('articles.show', $comment->article)); ?>" target="_blank"><?php echo e($comment->article->title); ?></a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="<?php echo e(route('admin.comments.edit', $comment)); ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Comment
                            </a>
                        </div>
                        <div>
                            <?php if($comment->is_approved): ?>
                                <form action="<?php echo e(route('admin.comments.unapprove', $comment)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Unapprove
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('admin.comments.approve', $comment)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form action="<?php echo e(route('admin.comments.destroy', $comment)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this comment?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replies -->
            <?php if($comment->replies->count() > 0): ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Replies (<?php echo e($comment->replies->count()); ?>)</h4>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="comment mb-3 pb-3 border-bottom">
                                <div class="d-flex">
                                    <img src="<?php echo e($reply->user->getAvatarUrl()); ?>" alt="<?php echo e($reply->user->name); ?>"
                                         class="rounded-circle me-3" width="40" height="40">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6><?php echo e($reply->user->name); ?></h6>
                                                <small class="text-muted"><?php echo e($reply->created_at->format('M d, Y H:i')); ?></small>
                                            </div>
                                            <div>
                                                <?php if($reply->is_approved): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="mt-2 p-2 bg-light rounded">
                                            <?php echo e($reply->content); ?>

                                        </div>
                                        <div class="mt-2">
                                            <a href="<?php echo e(route('admin.comments.show', $reply)); ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                            <a href="<?php echo e(route('admin.comments.edit', $reply)); ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="<?php echo e(route('admin.comments.destroy', $reply)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Comment Info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Comment Information</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>ID:</th>
                            <td><?php echo e($comment->id); ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <?php if($comment->is_approved): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td><?php echo e($comment->created_at->format('M d, Y H:i:s')); ?></td>
                        </tr>
                        <tr>
                            <th>Updated:</th>
                            <td><?php echo e($comment->updated_at->format('M d, Y H:i:s')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- User Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">User Information</h4>
                </div>
                <div class="card-body text-center">
                    <img src="<?php echo e($comment->user->getAvatarUrl()); ?>" alt="<?php echo e($comment->user->name); ?>"
                         class="rounded-circle mb-3" width="80" height="80">
                    <h5><?php echo e($comment->user->name); ?></h5>
                    <p class="text-muted"><?php echo e($comment->user->email); ?></p>
                    <div class="d-flex justify-content-center">
                        <?php if($comment->user->isAdmin()): ?>
                            <span class="badge bg-danger">Administrator</span>
                        <?php elseif($comment->user->isStaff()): ?>
                            <span class="badge bg-warning">Staff</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">User</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Article Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Article Information</h4>
                </div>
                <div class="card-body">
                    <h6><?php echo e($comment->article->title); ?></h6>
                    <p class="text-muted small">By <?php echo e($comment->article->user->name); ?></p>
                    <p class="text-muted small">Published: <?php echo e($comment->article->published_at->format('M d, Y')); ?></p>
                    <a href="<?php echo e(route('articles.show', $comment->article)); ?>" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i> View Article
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\admin\comments\show.blade.php ENDPATH**/ ?>