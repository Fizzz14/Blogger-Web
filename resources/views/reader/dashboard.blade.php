@extends('template.app')

@section('title', 'Dashboard - BACAKUY')

@section('content')

<!-- User Info Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-primary text-white">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img src="{{ auth()->user()->getAvatarUrl() }}"
                             alt="{{ auth()->user()->name }}"
                             class="rounded-circle" width="80" height="80">
                    </div>
                    <div class="col">
                        <h3 class="mb-1">Selamat datang, {{ auth()->user()->name }}! 👋</h3>
                        <p class="mb-0 opacity-75">Ada artikel menarik apa hari ini?</p>
                    </div>
                    <div class="col-auto">
                        <div class="row text-center">
                            <div class="col">
                                <h4 class="mb-0">{{ $userStats['articles_read'] }}</h4>
                                <small>Artikel Dibaca</small>
                            </div>
                            <div class="col">
                                <h4 class="mb-0">{{ $userStats['comments_made'] }}</h4>
                                <small>Komentar</small>
                            </div>
                            <div class="col">
                                <h4 class="mb-0">{{ $userStats['likes_given'] }}</h4>
                                <small>Likes</small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Search Bar -->
                <div class="row mt-4">
                    <div class="col-12">
                        <form action="{{ route('reader.articles') }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0" 
                                       placeholder="Cari artikel, kategori, atau penulis..." 
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-light text-primary">
                                    <i class="bi bi-search me-1"></i> Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <!-- Quick Actions 4 Cards -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-lightning me-2"></i>Quick Actions
                </h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('reader.articles') }}" class="btn btn-primary d-flex flex-column align-items-center p-3 h-100 text-white text-decoration-none">
                            <i class="bi bi-journal-text fs-1 mb-2"></i>
                            <span>Browse Articles</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reader.articles') }}" class="btn btn-success d-flex flex-column align-items-center p-3 h-100 text-white text-decoration-none">
                            <i class="bi bi-plus-circle fs-1 mb-2"></i>
                            <span>New Article</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reader.articles') }}" class="btn btn-info d-flex flex-column align-items-center p-3 h-100 text-white text-decoration-none">
                            <i class="bi bi-bookmark-star fs-1 mb-2"></i>
                            <span>Bookmarks</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('reader.articles') }}" class="btn btn-warning d-flex flex-column align-items-center p-3 h-100 text-white text-decoration-none">
                            <i class="bi bi-bookmark fs-1 mb-2"></i>
                            <span>Saved Articles</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Berita Terkini Instagram Style -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card news-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock me-2"></i>Berita Terkini
                </h5>
                <a href="{{ route('reader.articles') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @foreach($recentArticles as $article)
                <div class="news-article">
                    <div class="row g-0">
                        <!-- Image Section -->
                        <div class="col-md-5">
                            @if($article->featured_image)
                            <a href="{{ route('reader.article.show', $article) }}">
                                <img src="{{ Storage::url($article->featured_image) }}" 
                                     class="img-fluid h-100 w-100 news-image" 
                                     alt="{{ $article->title }}"
                                     style="object-fit: cover; min-height: 320px;">
                            </a>
                            @else
                            <a href="{{ route('reader.article.show', $article) }}">
                                <div class="bg-secondary d-flex align-items-center justify-content-center h-100 news-image-placeholder"
                                     style="min-height: 320px;">
                                    <i class="bi bi-image text-white fs-1"></i>
                                </div>
                            </a>
                            @endif
                        </div>

                        <!-- Content Section -->
                        <div class="col-md-7">
                            <div class="news-content">
                                <!-- Article Header with Author Info -->
                                <div class="article-header d-flex align-items-center mb-3">
                                    <img src="{{ $article->user->getAvatarUrl() }}" 
                                         alt="{{ $article->user->name }}"
                                         class="rounded-circle me-3" width="50" height="50">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 fw-bold">{{ $article->user->name }}</h6>
                                        <div class="article-meta d-flex align-items-center text-muted small">
                                            <span class="me-3">
                                                <i class="bi bi-calendar3 me-1"></i>{{ $article->created_at->format('M d, Y') }}
                                            </span>
                                            <span class="me-3">
                                                <i class="bi bi-eye me-1"></i>{{ $article->view_count }} views
                                            </span>
                                            <span class="badge px-2 py-1" style="background-color: {{ $article->category->color }};">
                                                {{ $article->category->name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article Title with Better Typography -->
                                <h3 class="article-title mb-3">
                                    <a href="{{ route('reader.article.show', $article) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($article->title, 70) }}
                                    </a>
                                </h3>

                                <!-- Article Excerpt with Better Readability -->
                                <div class="article-excerpt mb-3">
                                    <p class="text-muted mb-0">
                                        {{ Str::limit($article->excerpt ?: strip_tags($article->content), 150) }}
                                    </p>
                                    <a href="{{ route('reader.article.show', $article) }}" class="text-primary text-decoration-none fw-bold mt-3 d-inline-block">
                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>

                                <!-- Engagement Bar with Instagram Style -->
                                <div class="engagement-bar">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-4">
                                            @php
                                                $isLiked = auth()->check() && count($article->likedByUsers) > 0;
                                            @endphp
                                            <button class="btn btn-link text-dark p-0 like-btn d-flex align-items-center {{ $isLiked ? 'liked' : '' }}" data-article-id="{{ $article->id }}">
                                                <i class="bi {{ $isLiked ? 'bi-heart-fill' : 'bi-heart' }} fs-5 me-1"></i>
                                                <span class="like-count">{{ $article->like_count }}</span>
                                            </button>
                                            <a href="{{ route('reader.article.show', $article) }}#comments" class="btn btn-link text-dark p-0 d-flex align-items-center">
                                                <i class="bi bi-chat fs-5 me-1"></i>
                                                <span>{{ $article->comments_count ?? 0 }}</span>
                                            </a>
                                            <button class="btn btn-link text-dark p-0 share-btn d-flex align-items-center">
                                                <i class="bi bi-send fs-5"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <small class="text-muted">
                                                <i class="bi bi-bookmark me-1"></i>Simpan
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- List Trending Articles -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-fire me-2"></i>Trending Articles
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($popularArticles as $article)
                    <a href="{{ route('reader.article.show', $article) }}"
                       class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ Str::limit($article->title, 50) }}</h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $article->category->name }}</small>
                            <small class="text-muted">
                                <i class="bi bi-eye me-1"></i>{{ $article->view_count }}
                            </small>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



<style>
.article-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.article-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.card-img-top {
    border-radius: 0.375rem 0.375rem 0 0;
}

/* Instagram Post Style */
.news-card {
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.news-article {
    transition: all 0.3s ease;
    padding: 2rem 0;
    position: relative;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.news-article:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.news-article:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.news-image {
    transition: transform 0.3s ease;
    border-radius: 0.75rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.news-article:hover .news-image {
    transform: scale(1.02);
}

.news-image-placeholder {
    border-radius: 0.75rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.news-content {
    padding: 1.5rem 1.5rem 1.5rem 2rem;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.news-article .like-btn:hover,
.news-article .share-btn:hover {
    color: #e1306c !important;
}

.news-article .like-btn.liked {
    color: #e1306c !important;
}

/* Improved Typography */
.article-title {
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 1.2rem;
    letter-spacing: -0.02em;
}

.article-title a {
    transition: color 0.2s ease;
    display: block;
}

.article-title a:hover {
    color: #0d6efd !important;
}

.article-excerpt {
    max-width: 100%;
    line-height: 1.8;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
    color: #495057;
    flex-grow: 1;
}

.article-meta {
    font-size: 0.9rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 0.5rem;
}

.article-meta i {
    font-size: 0.8rem;
}

/* Improved Visual Hierarchy */
.article-header {
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.engagement-bar {
    padding-top: 1rem;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    margin-top: auto;
}

/* Consistent Button Styling */
.engagement-bar button,
.engagement-bar a {
    font-weight: 500;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.4rem 0.8rem;
    border-radius: 0.3rem;
}

.engagement-bar button:hover,
.engagement-bar a:hover {
    transform: translateY(-2px);
    background-color: rgba(0, 0, 0, 0.05);
}

/* Improved Badge Styling */
.badge {
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 0.025em;
    padding: 0.3rem 0.8rem;
    border-radius: 1rem;
}

/* Better Read More Link */
.article-excerpt a {
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
}

.article-excerpt a:hover {
    transform: translateX(3px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .article-title {
        font-size: 1.4rem;
    }

    .article-excerpt {
        font-size: 1rem;
        line-height: 1.6;
    }

    .article-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .article-meta span {
        margin-bottom: 0.25rem;
    }

    .engagement-bar {
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .news-article {
        padding: 1.8rem 0;
    }

    .news-content {
        padding: 1.5rem;
    }
}

/* Improved Visual Hierarchy and Separation */
.article-detail-card {
    border-radius: 0.75rem;
    overflow: hidden;
}

.article-detail-card .card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
}

.article-detail-card .article-title {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.3;
    margin-bottom: 1.5rem;
}

.article-detail-card .article-image {
    border-radius: 0;
    box-shadow: none;
}

.article-detail-card .article-content {
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.7;
    font-size: 1.1rem;
}

/* Better Comment Section */
.comments-section {
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    padding-top: 1.5rem;
    margin-top: 2rem;
}

.comment-form-section {
    margin-top: 1rem;
}

.comment-form-section input {
    border-radius: 1.5rem;
    padding: 0.75rem 1.25rem;
}

/* Consistent Sidebar Cards */
.sidebar-card {
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.sidebar-card .card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    padding: 1rem 1.5rem;
    font-weight: 600;
}

.sidebar-card .card-body {
    padding: 1.5rem;
}

/* Better Article List in Sidebar */
.related-article {
    display: flex;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.related-article:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.related-article img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.5rem;
    margin-right: 1rem;
}

.related-article-content {
    flex-grow: 1;
}

.related-article-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    line-height: 1.3;
}

.related-article-meta {
    font-size: 0.85rem;
    color: #6c757d;
}

/* Quick Actions Card Styling */
.btn-primary, .btn-success, .btn-info, .btn-warning {
    border-radius: 0.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-primary:hover, .btn-success:hover, .btn-info:hover, .btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* Category Chips Styling */
.btn-outline-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Like button functionality
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const articleId = this.getAttribute('data-article-id');
            const likeCount = this.querySelector('span');
            const heartIcon = this.querySelector('i');

            // Toggle liked class
            this.classList.toggle('liked');

            // Toggle heart icon
            if (this.classList.contains('liked')) {
                heartIcon.classList.remove('bi-heart');
                heartIcon.classList.add('bi-heart-fill');

                // Increment like count
                let count = parseInt(likeCount.textContent);
                likeCount.textContent = count + 1;

                // Send like request to server
                fetch(`/articles/${articleId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Article liked successfully');
                    } else {
                        // Revert UI changes if request failed
                        this.classList.remove('liked');
                        heartIcon.classList.remove('bi-heart-fill');
                        heartIcon.classList.add('bi-heart');
                        let count = parseInt(likeCount.textContent);
                        likeCount.textContent = count - 1;
                    }
                })
                .catch(error => {
                    console.error('Error liking article:', error);
                    // Revert UI changes if request failed
                    this.classList.remove('liked');
                    heartIcon.classList.remove('bi-heart-fill');
                    heartIcon.classList.add('bi-heart');
                    let count = parseInt(likeCount.textContent);
                    likeCount.textContent = count - 1;
                });
            } else {
                heartIcon.classList.remove('bi-heart-fill');
                heartIcon.classList.add('bi-heart');

                // Decrement like count
                let count = parseInt(likeCount.textContent);
                likeCount.textContent = count - 1;

                // Send unlike request to server
                fetch(`/articles/${articleId}/unlike`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Article unliked successfully');
                    } else {
                        // Revert UI changes if request failed
                        this.classList.add('liked');
                        heartIcon.classList.remove('bi-heart');
                        heartIcon.classList.add('bi-heart-fill');
                        let count = parseInt(likeCount.textContent);
                        likeCount.textContent = count + 1;
                    }
                })
                .catch(error => {
                    console.error('Error unliking article:', error);
                    // Revert UI changes if request failed
                    this.classList.add('liked');
                    heartIcon.classList.remove('bi-heart');
                    heartIcon.classList.add('bi-heart-fill');
                    let count = parseInt(likeCount.textContent);
                    likeCount.textContent = count + 1;
                });
            }
        });
    });

    // Share button functionality
    const shareButtons = document.querySelectorAll('.share-btn');

    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Create a simple modal for sharing options
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'shareModal';
            modal.setAttribute('tabindex', '-1');
            modal.setAttribute('aria-labelledby', 'shareModalLabel');
            modal.setAttribute('aria-hidden', 'true');

            modal.innerHTML = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="shareModalLabel">Share Article</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" onclick="shareOnSocial('facebook')">
                                    <i class="bi bi-facebook me-2"></i>Share on Facebook
                                </button>
                                <button class="btn btn-info text-white" onclick="shareOnSocial('twitter')">
                                    <i class="bi bi-twitter me-2"></i>Share on Twitter
                                </button>
                                <button class="btn btn-success" onclick="shareOnSocial('whatsapp')">
                                    <i class="bi bi-whatsapp me-2"></i>Share on WhatsApp
                                </button>
                                <button class="btn btn-secondary" onclick="copyLink()">
                                    <i class="bi bi-link-45deg me-2"></i>Copy Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);

            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();

            // Remove modal from DOM after it's hidden
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.removeChild(modal);
            });
        });
    });

    // Function to share on social media
    window.shareOnSocial = function(platform) {
        const articleUrl = window.location.href;
        const articleTitle = document.querySelector('h5.card-title a').textContent;

        let shareUrl = '';

        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(articleUrl)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(articleTitle)}&url=${encodeURIComponent(articleUrl)}`;
                break;
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${encodeURIComponent(articleTitle + ' ' + articleUrl)}`;
                break;
        }

        if (shareUrl) {
            window.open(shareUrl, '_blank');
        }

        // Close the modal
        const modal = document.getElementById('shareModal');
        const bootstrapModal = bootstrap.Modal.getInstance(modal);
        bootstrapModal.hide();
    };

    // Function to copy link to clipboard
    window.copyLink = function() {
        const articleUrl = window.location.href;

        navigator.clipboard.writeText(articleUrl).then(function() {
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'position-fixed bottom-0 end-0 p-3';
            toast.style.zIndex = '11';
            toast.innerHTML = `
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Link copied to clipboard!
                    </div>
                </div>
            `;

            document.body.appendChild(toast);

            // Remove toast after 3 seconds
            setTimeout(function() {
                document.body.removeChild(toast);
            }, 3000);
        });

        // Close the modal
        const modal = document.getElementById('shareModal');
        const bootstrapModal = bootstrap.Modal.getInstance(modal);
        bootstrapModal.hide();
    };

    // Like functionality
    document.addEventListener('DOMContentLoaded', function() {
        const likeButtons = document.querySelectorAll('.like-btn');

        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const articleId = this.getAttribute('data-article-id');
                const likeCount = this.querySelector('.like-count');
                const heartIcon = this.querySelector('i');

                // Get current like count
                const currentCount = parseInt(likeCount.textContent);

                // Send AJAX request to update like status
                fetch(`/reader/articles/${articleId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI based on response
                        if (data.liked) {
                            this.classList.add('liked');
                            heartIcon.classList.remove('bi-heart');
                            heartIcon.classList.add('bi-heart-fill');
                        } else {
                            this.classList.remove('liked');
                            heartIcon.classList.remove('bi-heart-fill');
                            heartIcon.classList.add('bi-heart');
                        }
                        likeCount.textContent = data.like_count;
                    } else {
                        // Revert changes if request failed
                        this.classList.toggle('liked');
                        if (heartIcon.classList.contains('bi-heart')) {
                            heartIcon.classList.remove('bi-heart');
                            heartIcon.classList.add('bi-heart-fill');
                        } else {
                            heartIcon.classList.remove('bi-heart-fill');
                            heartIcon.classList.add('bi-heart');
                        }
                        likeCount.textContent = currentCount;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Revert changes if request failed
                    this.classList.toggle('liked');
                    if (heartIcon.classList.contains('bi-heart')) {
                        heartIcon.classList.remove('bi-heart');
                        heartIcon.classList.add('bi-heart-fill');
                    } else {
                        heartIcon.classList.remove('bi-heart-fill');
                        heartIcon.classList.add('bi-heart');
                    }
                    likeCount.textContent = currentCount;
                });
            });
        });
    });
});
</script>
@endsection
