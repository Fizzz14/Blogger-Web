

<?php $__env->startSection('title', 'Edit Comment'); ?>

<?php $__env->startSection('staff_content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Comment</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('staff.comments.show', $comment)); ?>" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Comment
                        </a>
                    </div>
                </div>
                <form action="<?php echo e(route('staff.comments.update', $comment)); ?>" method="POST">
                    <?php echo method_field("PUT"); ?>
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="content">Comment Content</label>
                                    <textarea class="form-control" id="content" name="content" rows="5" required><?php echo e($comment->content); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="is_approved" name="is_approved" value="1" <?php echo e($comment->is_approved ? 'checked' : ''); ?>>
                                        <label for="is_approved">Approved</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="<?php echo e(route('staff.comments.show', $comment)); ?>" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
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

            <!-- Parent Comment -->
            <?php if($comment->parent): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Replying To</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <img src="<?php echo e($comment->parent->user->getAvatarUrl()); ?>" alt="<?php echo e($comment->parent->user->name); ?>"
                             class="rounded-circle me-2" width="40" height="40">
                        <div class="flex-grow-1">
                            <h6><?php echo e($comment->parent->user->name); ?></h6>
                            <small class="text-muted"><?php echo e($comment->parent->created_at->format('M d, Y H:i')); ?></small>
                            <div class="mt-2 p-2 bg-light rounded">
                                <?php echo e($comment->parent->content); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Initialize iCheck plugin
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\staff\comments\edit.blade.php ENDPATH**/ ?>