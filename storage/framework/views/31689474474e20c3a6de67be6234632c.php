

<?php $__env->startSection('title', 'Manage Comments'); ?>

<?php $__env->startSection('staff_content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Comments</h3>
                    <div class="card-tools">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="comments-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($comment->id); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('articles.show', $comment->article)); ?>" target="_blank">
                                            <?php echo e(Str::limit($comment->article->title, 30)); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e($comment->user->getAvatarUrl()); ?>" alt="<?php echo e($comment->user->name); ?>"
                                                 class="rounded-circle me-2" width="30" height="30">
                                            <?php echo e($comment->user->name); ?>

                                        </div>
                                    </td>
                                    <td><?php echo e(Str::limit($comment->content, 50)); ?></td>
                                    <td>
                                        <?php if($comment->is_approved): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($comment->created_at->format('M d, Y H:i')); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('staff.comments.show', $comment)); ?>" class="btn btn-info btn-sm">Detail
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('staff.comments.edit', $comment)); ?>" class="btn btn-warning btn-sm">Edit
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('staff.comments.destroy', $comment)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash">Delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function () {
    var table = $("#comments-table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "dom": 'lrtip', // Remove default search
        "language": {
            "search": "",
            "searchPlaceholder": "Search..."
        }
    }).buttons().container().appendTo('#comments-table_wrapper .col-md-6:eq(0)');
    
    // Custom search functionality
    $('input[name="table_search"]').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views/staff/comments/index.blade.php ENDPATH**/ ?>