<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?php echo e(route('articles.create')); ?>" class="btn btn-primary me-2">
            <i class="bi bi-plus-circle me-2"></i>New Article
        </a>
        <?php if(auth()->user()->isAdmin() || auth()->user()->isStaff()): ?>
        <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary me-2">
            <i class="bi bi-tag me-2"></i>New Category
        </a>
        <?php endif; ?>
        <?php if(auth()->user()->isAdmin()): ?>
        <a href="<?php echo e(route('users.create-staff')); ?>" class="btn btn-primary">
            <i class="bi bi-person-plus me-2"></i>Add Staff
        </a>
        <?php endif; ?>
        <?php if(auth()->user()->isAdmin() || auth()->user()->isStaff()): ?>
        <a href="<?php echo e(route('admin.comments.index')); ?>" class="btn btn-primary">
            <i class="bi bi-chat-dots me-2"></i>Manage Comments
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 bg-primary bg-gradient">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-white"><?php echo e($stats['total_articles']); ?></h2>
                        <p class="mb-0 text-white-50">Total Articles</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="bi bi-journal-text text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 bg-success bg-gradient">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-white"><?php echo e($stats['published_articles']); ?></h2>
                        <p class="mb-0 text-white-50">Published</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="bi bi-check-circle text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 bg-warning bg-gradient">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-white"><?php echo e($stats['draft_articles']); ?></h2>
                        <p class="mb-0 text-white-50">Drafts</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="bi bi-pencil text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 bg-info bg-gradient">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-white"><?php echo e($stats['total_categories']); ?></h2>
                        <p class="mb-0 text-white-50">Categories</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="bi bi-tags text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Only Stats -->
<?php if(auth()->user()->isAdmin()): ?>
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 bg-secondary bg-gradient">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-white"><?php echo e($stats['total_users']); ?></h2>
                        <p class="mb-0 text-white-50">Total Users</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="bi bi-people text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-0 bg-purple bg-gradient" style="background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%) !important;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-white"><?php echo e($stats['total_staff']); ?></h2>
                        <p class="mb-0 text-white-50">Staff Members</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                        <i class="bi bi-shield-check text-white fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <!-- Recent Articles -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i>Recent Articles
                </h5>
                <a href="<?php echo e(route('articles.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if($recentArticles->count() > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $recentArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="list-group-item bg-transparent text-light border-secondary article-card">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1 me-3">
                                    <h6 class="mb-1"><?php echo e(Str::limit($article->title, 60)); ?></h6>
                                    <p class="mb-1 text-muted small"><?php echo e(Str::limit($article->excerpt ?: strip_tags($article->content), 100)); ?></p>
                                    <div class="d-flex align-items-center small text-muted">
                                        <span class="badge me-2" style="background-color: <?php echo e($article->category->color); ?>;">
                                            <?php echo e($article->category->name); ?>

                                        </span>
                                        <span class="me-3">
                                            <i class="bi bi-eye me-1"></i><?php echo e($article->view_count); ?>

                                        </span>
                                        <span class="me-3">
                                            <i class="bi bi-clock me-1"></i><?php echo e($article->getReadingTime()); ?> min read
                                        </span>
                                        <span class="badge bg-<?php echo e($article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'secondary')); ?>">
                                            <?php echo e(ucfirst($article->status)); ?>

                                        </span>
                                    </div>
                                </div>
                                <small class="text-muted"><?php echo e($article->created_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-journal-text display-4 text-muted mb-3"></i>
                        <p class="text-muted">No articles yet. Start writing your first article!</p>
                        <a href="<?php echo e(route('articles.create')); ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Create Article
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Popular Articles -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('articles.create')); ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>New Article
                    </a>
                    <?php if(auth()->user()->isAdmin() || auth()->user()->isStaff()): ?>
                    <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-tag me-2"></i>New Category
                    </a>
                    <?php endif; ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('users.create-staff')); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-person-plus me-2"></i>Add Staff
                    </a>
                    <?php endif; ?>
                    <?php if(auth()->user()->isAdmin() || auth()->user()->isStaff()): ?>
                    <a href="<?php echo e(route('admin.comments.index')); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-chat-dots me-2"></i>Manage Comments
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Popular Articles -->
        <?php if($popularArticles->count() > 0): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-fire me-2"></i>Popular Articles
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php $__currentLoopData = $popularArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('articles.show', $article)); ?>" class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><?php echo e(Str::limit($article->title, 40)); ?></h6>
                            <small class="text-muted"><?php echo e($article->view_count); ?> views</small>
                        </div>
                        <small class="text-muted"><?php echo e($article->category->name); ?> • <?php echo e($article->created_at->diffForHumans()); ?></small>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\dashboard.blade.php ENDPATH**/ ?>