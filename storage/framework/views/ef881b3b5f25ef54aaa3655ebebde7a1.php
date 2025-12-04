<?php $__env->startSection('title', 'Search Results: ' . $query); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <!-- Search Header -->
        <div class="card mb-4">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('reader.dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('reader.articles')); ?>">Articles</a></li>
                        <li class="breadcrumb-item active">Search Results</li>
                    </ol>
                </nav>

                <h1 class="gradient-text mb-3">Search Results</h1>
                <p class="text-muted"><?php echo e($articles->count()); ?> articles found for "<?php echo e($query); ?>"</p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('reader.search')); ?>" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo e($query); ?>" placeholder="Search articles...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Articles List -->
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <?php if($article->featured_image): ?>
                            <img src="<?php echo e(Storage::url($article->featured_image)); ?>" alt="<?php echo e($article->title); ?>"
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo e(Str::limit($article->title, 50)); ?></h5>
                            <p class="card-text text-muted small">
                                By <?php echo e($article->user->name); ?> • <?php echo e($article->published_at->format('M d, Y')); ?>

                            </p>
                            <p class="card-text"><?php echo e(Str::limit($article->excerpt ?: strip_tags($article->content), 100)); ?></p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge" style="background-color: <?php echo e($article->category->color); ?>;">
                                        <?php echo e($article->category->name); ?>

                                    </span>
                                    <div class="text-muted small">
                                        <i class="bi bi-eye me-1"></i><?php echo e($article->view_count); ?>

                                        <i class="bi bi-heart ms-2 me-1"></i><?php echo e($article->like_count); ?>

                                    </div>
                                </div>
                                <a href="<?php echo e(route('reader.article.show', $article)); ?>" class="btn btn-primary mt-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-search display-1 text-muted"></i>
                        <h3 class="mt-3">No articles found</h3>
                        <p class="text-muted">Try searching with different keywords.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if($articles->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($articles->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Categories -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-tags me-2"></i>Categories
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('reader.articles.category', $category)); ?>"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><?php echo e($category->name); ?></span>
                            <span class="badge bg-primary rounded-pill"><?php echo e($category->articles()->published()->count()); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Popular Articles -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-fire me-2"></i>Popular Articles
                </h5>
            </div>
            <div class="card-body">
                <?php
                    $popularArticles = App\Models\Article::with(['user', 'category'])
                        ->where('status', 'published')
                        ->orderBy('view_count', 'desc')
                        ->take(5)
                        ->get();
                ?>

                <?php if($popularArticles->count() > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $popularArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popular): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('reader.article.show', $popular)); ?>"
                               class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo e(Str::limit($popular->title, 40)); ?></h6>
                                </div>
                                <small class="text-muted"><?php echo e($popular->created_at->diffForHumans()); ?></small>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No popular articles found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projek\resources\views\reader\search.blade.php ENDPATH**/ ?>