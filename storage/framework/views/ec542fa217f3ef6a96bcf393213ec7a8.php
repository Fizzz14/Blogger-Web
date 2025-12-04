<?php $__env->startSection('title', 'Categories Datatables - Staff'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-tags me-2"></i>Categories Management
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-secondary me-2">
            <i class="bi bi-list me-2"></i>Normal View
        </a>
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
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="search-addon"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="categories-search" placeholder="Search categories...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="articles-filter">
                    <option value="">All Categories</option>
                    <option value="has_articles">Has Articles</option>
                    <option value="no_articles">No Articles</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="color-filter">
                    <option value="">All Colors</option>
                    <?php $__currentLoopData = $colors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($color); ?>"><?php echo e($color); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="categories-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Color</th>
                        <th>Articles</th>
                        <th>Description</th>
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
    var table = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo e(route("staff.categories.datatables")); ?>',
            data: function(d) {
                d.search = $('#categories-search').val();
                d.articles = $('#articles-filter').val();
                d.color = $('#color-filter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'color', name: 'color' },
            { data: 'articles_count', name: 'articles_count' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
    });
    
    // Custom search
    $('#categories-search').on('keyup', function() {
        table.draw();
    });
    
    // Articles filter
    $('#articles-filter').on('change', function() {
        table.draw();
    });
    
    // Color filter
    $('#color-filter').on('change', function() {
        table.draw();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\staff\categories\datatables.blade.php ENDPATH**/ ?>