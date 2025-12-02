<?php $__env->startSection('title', 'Staff Dashboard'); ?>

<?php $__env->startSection('staff_content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?php echo e(route('staff.comments.datatables')); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-table me-1"></i> Comments
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Articles
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($stats['total_articles']); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-journal-text fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Published Articles
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($stats['published_articles']); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Comments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($stats['total_comments']); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-left-text fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Comments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo e($stats['pending_comments']); ?>

                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Comments -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recent Comments</h6>
                <a href="<?php echo e(route('staff.comments.index')); ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php
                    $recentComments = App\Models\Comment::with(['user', 'article'])
                        ->latest()
                        ->take(5)
                        ->get();
                ?>

                <?php if($recentComments->count() > 0): ?>
                    <?php $__currentLoopData = $recentComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1"><?php echo e(Str::limit($comment->content, 50)); ?></h6>
                                <?php if($comment->is_approved): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php endif; ?>
                            </div>
                            <div class="small text-muted">
                                By <?php echo e($comment->user->name); ?> on <?php echo e($comment->article->title); ?>

                            </div>
                            <div class="mt-2">
                                <a href="<?php echo e(route('staff.comments.show', $comment)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <?php if(!$comment->is_approved): ?>
                                    <form action="<?php echo e(route('staff.comments.approve', $comment)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check"></i> Approve
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted">No comments found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Articles -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recent Articles</h6>
                <a href="<?php echo e(route('staff.articles.datatables')); ?>" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <?php
                    $recentArticles = App\Models\Article::with(['user', 'category'])
                        ->latest()
                        ->take(5)
                        ->get();
                ?>

                <?php if($recentArticles->count() > 0): ?>
                    <?php $__currentLoopData = $recentArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3 pb-3 border-bottom">
                            <h6 class="mb-1"><?php echo e($article->title); ?></h6>
                            <div class="small text-muted">
                                By <?php echo e($article->user->name); ?> • <?php echo e($article->created_at->format('M d, Y')); ?>

                            </div>
                            <div class="mt-2">
                                <span class="badge me-1" style="background-color: <?php echo e($article->category->color); ?>;">
                                    <?php echo e($article->category->name); ?>

                                </span>
                                <span class="badge bg-secondary me-1"><?php echo e($article->view_count); ?> views</span>
                                <span class="badge bg-danger"><?php echo e($article->like_count); ?> likes</span>
                            </div>
                            <div class="mt-2">
                                <a href="<?php echo e(route('articles.show', $article)); ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted">No articles found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.staff', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\staff\dashboard.blade.php ENDPATH**/ ?>