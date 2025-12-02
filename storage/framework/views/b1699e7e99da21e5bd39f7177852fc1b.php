

<?php $__env->startSection('title', 'Articles Datatables - Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-file-text me-2"></i>Articles Management
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-secondary me-2">
            <i class="bi bi-list me-2"></i>Normal View
        </a>
        <a href="<?php echo e(route('articles.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>New Article
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Articles</h5>
        <div>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo e(route('articles.export')); ?>">Export as Excel</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <a href="<?php echo e(route('articles.trash')); ?>" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash me-1"></i>View Trash
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="search-addon"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="articles-search" placeholder="Search articles...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="status-filter">
                    <option value="">All Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="category-filter">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="articles-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Likes</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<script>
$(document).ready(function() {
    var table = $('#articles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo e(route("staff.articles.datatables")); ?>',
            data: function(d) {
                d.search = $('#articles-search').val();
                d.status = $('#status-filter').val();
                d.category = $('#category-filter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'author', name: 'user.name' },
            { data: 'category', name: 'category.name' },
            { data: 'status', name: 'status' },
            { data: 'views', name: 'view_count', orderable: true },
            { data: 'likes', name: 'like_count', orderable: true },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
    });
    
    // Custom search
    $('#articles-search').on('keyup', function() {
        table.draw();
    });
    
    // Status filter
    $('#status-filter').on('change', function() {
        table.draw();
    });
    
    // Category filter
    $('#category-filter').on('change', function() {
        table.draw();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\staff\articles\datatables.blade.php ENDPATH**/ ?>