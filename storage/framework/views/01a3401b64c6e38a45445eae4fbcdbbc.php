<?php $__env->startSection('title', 'Manage Articles - Admin'); ?>

<?php $__env->startSection('admin_content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Articles</h3>
                    <div class="card-tools d-flex justify-content-between w-100">
                        <div class="btn-group">
                            <a href="<?php echo e(route('admin.articles.export')); ?>" class="btn btn-default btn-sm">
                                <i class="fas fa-download"></i> Export
                            </a>
                        </div>
                        <div class="input-group" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search articles...">
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
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category-filter">Filter by Category</label>
                                <select class="form-control" id="category-filter">
                                    <option value="">All Categories</option>
                                    <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status-filter">Filter by Status</label>
                                <select class="form-control" id="status-filter">
                                    <option value="">All Status</option>
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button id="reset-filters" class="btn btn-secondary w-100">
                                <i class="fas fa-sync-alt me-2"></i>Reset Filters
                            </button>
                        </div>
                    </div>
                    <table id="articles-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Likes</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($article->id); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.articles.show', $article)); ?>" target="_blank">
                                            <?php echo e(Str::limit($article->title, 30)); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: <?php echo e($article->category->color); ?>;">
                                            <?php echo e($article->category->name); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e($article->user->getAvatarUrl()); ?>" alt="<?php echo e($article->user->name); ?>"
                                                 class="rounded-circle me-2" width="30" height="30">
                                            <?php echo e($article->user->name); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <?php if($article->status === 'published'): ?>
                                            <span class="badge bg-success">Published</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($article->view_count); ?></td>
                                    <td><?php echo e($article->like_count); ?></td>
                                    <td><?php echo e($article->created_at->format('M d, Y H:i')); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('admin.articles.show', $article)); ?>" class="btn btn-info btn-sm">Detail
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" class="btn btn-warning btn-sm">Edit
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.articles.destroy', $article)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this article?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function () {
    var table = $("#articles-table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "dom": 'lrtip', // Remove default search
        "language": {
            "search": "",
            "searchPlaceholder": "Search articles..."
        }
    }).buttons().container().appendTo('#articles-table_wrapper .col-md-6:eq(0)');
    
    // Custom search functionality
    $('input[name="table_search"]').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Category filter
    $('#category-filter').on('change', function() {
        table.column(2).search($(this).val()).draw();
    });
    
    // Status filter
    $('#status-filter').on('change', function() {
        table.column(4).search($(this).val()).draw();
    });
    
    // Reset filters
    $('#reset-filters').on('click', function() {
        $('#category-filter').val('');
        $('#status-filter').val('');
        $('input[name="table_search"]').val('');
        table.search('').columns().search('').draw();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\admin\articles\index.blade.php ENDPATH**/ ?>