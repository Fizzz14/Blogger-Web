<?php $__env->startSection('title', 'Comments Datatables - Staff'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-chat-dots me-2"></i>Comments Management
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('staff.comments.index')); ?>" class="btn btn-secondary me-2">
            <i class="bi bi-list me-2"></i>Normal View
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Comments</h5>
        <div>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-excel me-1"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo e(route('staff.comments.export')); ?>">Export as Excel</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-arrow-up me-1"></i>Import
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo e(asset('storage/templates/comments_import_template.xlsx')); ?>" download>Download Template</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="<?php echo e(route('staff.comments.import')); ?>" method="POST" enctype="multipart/form-data" class="p-2">
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
                    <input type="text" class="form-control" id="comments-search" placeholder="Search comments...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="status-filter">
                    <option value="">All Status</option>
                    <option value="1">Approved</option>
                    <option value="0">Pending</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="article-filter">
                    <option value="">All Articles</option>
                    <?php $__currentLoopData = $articles ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($article->id); ?>"><?php echo e(Str::limit($article->title, 30)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="comments-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Content</th>
                        <th>Author</th>
                        <th>Article</th>
                        <th>Status</th>
                        <th>Date</th>
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
    var table = $('#comments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?php echo e(route("staff.comments.datatables")); ?>',
            data: function(d) {
                d.search = $('#comments-search').val();
                d.status = $('#status-filter').val();
                d.article = $('#article-filter').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'content', name: 'content' },
            { data: 'author', name: 'user.name' },
            { data: 'article', name: 'article.title' },
            { data: 'status', name: 'is_approved' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[5, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        language: {
            search: "",
            searchPlaceholder: "Search..."
        }
    });

    // Custom search - Connect DataTables search with custom search
    $('#comments-search').on('keyup', function() {
        // Set the value to DataTables search
        table.search($(this).val()).draw();
    });
    
    // Also update our custom search when DataTables search changes
    $('#comments-table_filter input').on('keyup', function() {
        $('#comments-search').val($(this).val());
    });
    
    // Hide the default search box
    $('#comments-table_filter').hide();

    // Status filter
    $('#status-filter').on('change', function() {
        table.draw();
    });

    // Article filter
    $('#article-filter').on('change', function() {
        table.draw();
    });

    // Handle form submission for approve/unapprove
    $(document).on('submit', 'form[action*="approve"], form[action*="unapprove"]', function(e) {
        e.preventDefault();

        var form = $(this);
        var action = form.attr('action');
        var method = form.attr('method');

        var buttonText = form.find('button').text().trim();
        if (confirm('Are you sure you want to ' + buttonText.toLowerCase() + ' this comment?')) {
            $.ajax({
                url: action,
                type: method,
                data: form.serialize(),
                success: function(response) {
                    // Remove any existing alerts first
                    $('.alert').alert('close');
                    
                    // Show success message
                    if (typeof response.success !== 'undefined') {
                        var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            response.success +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        $('.card-header').after(alertHtml);
                        // Auto dismiss after 3 seconds
                        setTimeout(function() {
                            $('.alert-success').alert('close');
                        }, 3000);
                    }
                    
                    // Reload the table without callback
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    // Remove any existing alerts first
                    $('.alert').alert('close');
                    
                    // Show error message
                    var alertHtml = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        xhr.responseJSON.message || 'An error occurred while processing your request.' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                    $('.card-header').after(alertHtml);
                    // Auto dismiss after 3 seconds
                    setTimeout(function() {
                        $('.alert-danger').alert('close');
                    }, 3000);
                }
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\staff\comments\datatables.blade.php ENDPATH**/ ?>