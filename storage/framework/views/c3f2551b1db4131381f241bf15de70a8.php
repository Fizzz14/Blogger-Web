<?php $__env->startSection('title', 'Semua Artikel - BACAKUY'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="h3 gradient-text mb-0">Semua Artikel</h1>
                <p class="text-muted">Jelajahi semua artikel menarik di BACAKUY</p>

                <!-- Search Form -->
                <form action="<?php echo e(route('reader.search')); ?>" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control"
                               placeholder="Cari artikel..." value="<?php echo e(request('q')); ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Category Filter -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="<?php echo e(route('reader.articles')); ?>"
                       class="btn btn-sm <?php echo e(!request('category') ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        Semua
                    </a>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('reader.articles.category', $category)); ?>"
                       class="btn btn-sm <?php echo e(request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        <?php echo e($category->name); ?>

                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card article-card h-100">
            <?php if($article->featured_image): ?>
            <img src="<?php echo e(Storage::url($article->featured_image)); ?>"
                 class="card-img-top" alt="<?php echo e($article->title); ?>"
                 style="height: 200px; object-fit: cover;">
            <?php else: ?>
            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                 style="height: 200px;">
                <i class="bi bi-image text-white fs-1"></i>
            </div>
            <?php endif; ?>

            <div class="card-body">
                <span class="badge mb-2" style="background-color: <?php echo e($article->category->color); ?>;">
                    <?php echo e($article->category->name); ?>

                </span>
                <h5 class="card-title">
                    <a href="<?php echo e(route('reader.article.show', $article)); ?>" class="text-decoration-none text-white">
                        <?php echo e(Str::limit($article->title, 70)); ?>

                    </a>
                </h5>
                <p class="card-text text-muted">
                    <?php echo e(Str::limit($article->excerpt ?: strip_tags($article->content), 120)); ?>

                </p>
            </div>

            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e($article->user->getAvatarUrl()); ?>"
                             alt="<?php echo e($article->user->name); ?>"
                             class="rounded-circle me-2" width="24" height="24">
                        <small class="text-muted"><?php echo e($article->user->name); ?></small>
                    </div>
                    <small class="text-muted"><?php echo e($article->created_at->diffForHumans()); ?></small>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted">
                        <i class="bi bi-eye me-1"></i><?php echo e($article->view_count); ?>

                    </small>
                    <small class="text-muted">
                        <i class="bi bi-heart me-1"></i><?php echo e($article->like_count); ?>

                    </small>
                    <small class="text-muted">
                        <i class="bi bi-chat me-1"></i><?php echo e($article->comments_count ?? 0); ?>

                    </small>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Pagination -->
<?php if($articles->hasPages()): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php echo e($articles->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
.article-card {
    transition: all 0.3s ease;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hafizh\Blogger.web\resources\views\reader\articles.blade.php ENDPATH**/ ?>