@extends('template.app')

@section('title', $article->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Article Card - Instagram Style -->
        <div class="card mb-4 shadow-sm">
            <!-- Article Header -->
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <div class="d-flex align-items-center">
                    <img src="{{ $article->user->getAvatarUrl() }}" alt="{{ $article->user->name }}"
                         class="rounded-circle me-3" width="40" height="40">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">{{ $article->user->name }}</h6>
                        <small class="text-muted">{{ $article->published_at->format('M d, Y') }} · {{ $article->category->name }}</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm" type="button" id="articleMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="articleMenu">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-bookmark me-2"></i>Save Article</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-share me-2"></i>Share</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-flag me-2"></i>Report</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Article Title -->
            <div class="px-3 pt-2">
                <h5 class="fw-bold">{{ $article->title }}</h5>
            </div>

            <!-- Featured Image -->
            @if($article->featured_image)
            <div class="card-body p-0">
                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                     class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
            </div>
            @endif

            <!-- Article Actions -->
            <div class="card-body pt-3 pb-2">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <!-- Like Button -->
                        <button class="btn btn-link text-dark p-0 me-3 like-btn" data-article-id="{{ $article->id }}">
                            <i class="bi bi-heart fs-5"></i>
                        </button>
                        <!-- Comment Button -->
                        <button class="btn btn-link text-dark p-0 me-3 comment-btn">
                            <i class="bi bi-chat fs-5"></i>
                        </button>
                        <!-- Share Button -->
                        <button class="btn btn-link text-dark p-0 share-btn" data-bs-toggle="modal" data-bs-target="#shareModal">
                            <i class="bi bi-send fs-5"></i>
                        </button>
                    </div>
                    <!-- Bookmark Button -->
                    <button class="btn btn-link text-dark p-0 bookmark-btn">
                        <i class="bi bi-bookmark fs-5"></i>
                    </button>
                </div>
                <div class="fw-bold mb-2">
                    <span class="like-count">{{ $article->like_count }}</span> likes
                </div>
            </div>

            <!-- Article Content -->
            <div class="card-body pt-0">
                <div class="article-content">
                    <p>{!! nl2br(e(Str::limit($article->content, 300))) !!}</p>
                    @if(strlen($article->content) > 300)
                    <button class="btn btn-link p-0 text-muted more-content-btn">more</button>
                    <div class="full-content" style="display: none;">
                        <p>{!! nl2br(e($article->content)) !!}</p>
                        <button class="btn btn-link p-0 text-muted less-content-btn">less</button>
                    </div>
                    @endif
                </div>

                <!-- View Comments Link -->
                @if($article->comments->count() > 0)
                <button class="btn btn-link p-0 text-muted view-comments-btn mt-2">
                    View all {{ $article->comments->count() }} comments
                </button>
                @endif

                <!-- Add Comment Form -->
                <div class="mt-2 comment-form-section">
                    <form action="{{ route('comments.store', $article) }}" method="POST" class="d-flex">
                        @csrf
                        <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}"
                             class="rounded-circle me-2" width="32" height="32">
                        <div class="flex-grow-1">
                            <input type="text" name="content" class="form-control border-0"
                                   placeholder="Add a comment..." required>
                        </div>
                        <button type="submit" class="btn btn-link text-primary p-0 ms-2 fw-bold">Post</button>
                    </form>
                </div>

                <!-- Comments Section (Initially Hidden) -->
                <div class="comments-section mt-3" style="display: none;">
                    <hr>
                    @if($article->comments->count() > 0)
                        <div class="comments-list">
                            @foreach($article->comments as $comment)
                                <div class="comment mb-3">
                                    <div class="d-flex">
                                        <img src="{{ $comment->user->getAvatarUrl() }}"
                                             alt="{{ $comment->user->name }}"
                                             class="rounded-circle me-2" width="32" height="32">
                                        <div class="flex-grow-1">
                                            <div class="bg-light p-2 rounded">
                                                <h6 class="mb-0 fw-bold">{{ $comment->user->name }}</h6>
                                                <p class="mb-0">{{ $comment->content }}</p>
                                            </div>
                                            <div class="d-flex align-items-center mt-1">
                                                <button class="btn btn-link p-0 text-muted me-3 like-comment-btn">
                                                    <i class="bi bi-heart"></i>
                                                </button>
                                                <button class="btn btn-link p-0 text-muted me-3 reply-comment-btn" data-comment-id="{{ $comment->id }}">
                                                    Reply
                                                </button>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>

                                            <!-- Reply Form -->
                                            <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
                                                <form action="{{ route('comments.store', $article) }}" method="POST" class="d-flex">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                    <img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->name }}"
                                                         class="rounded-circle me-2" width="28" height="28">
                                                    <div class="flex-grow-1">
                                                        <input type="text" name="content" class="form-control border-0"
                                                               placeholder="Reply to {{ $comment->user->name }}..." required>
                                                    </div>
                                                    <button type="submit" class="btn btn-link text-primary p-0 ms-2 fw-bold">Post</button>
                                                    <button type="button" class="btn btn-link text-muted p-0 ms-1 cancel-reply" data-comment-id="{{ $comment->id }}">Cancel</button>
                                                </form>
                                            </div>

                                            <!-- Display Replies -->
                                            @if($comment->replies->count() > 0)
                                                <div class="replies mt-2 ms-4">
                                                    @foreach($comment->replies as $reply)
                                                        <div class="reply mb-2">
                                                            <div class="d-flex">
                                                                <img src="{{ $reply->user->getAvatarUrl() }}"
                                                                     alt="{{ $reply->user->name }}"
                                                                     class="rounded-circle me-2" width="28" height="28">
                                                                <div class="flex-grow-1">
                                                                    <div class="bg-light p-2 rounded">
                                                                        <h6 class="mb-0 fw-bold">{{ $reply->user->name }}</h6>
                                                                        <p class="mb-0">{{ $reply->content }}</p>
                                                                    </div>
                                                                    <div class="d-flex align-items-center mt-1">
                                                                        <button class="btn btn-link p-0 text-muted me-3 like-comment-btn">
                                                                            <i class="bi bi-heart"></i>
                                                                        </button>
                                                                        <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No comments yet. Be the first to comment!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Article Info -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>Article Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Category:</strong>
                    <span class="badge float-end" style="background-color: {{ $article->category->color }};">
                        {{ $article->category->name }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Published:</strong>
                    <span class="float-end">
                        {{ $article->published_at->format('M d, Y') }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Reading Time:</strong>
                    <span class="float-end">{{ $article->getReadingTime() }} min read</span>
                </div>
                <div>
                    <strong>Last Updated:</strong>
                    <span class="float-end">{{ $article->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Author Info -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person me-2"></i>About the Author
                </h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $article->user->getAvatarUrl() }}" alt="{{ $article->user->name }}"
                     class="rounded-circle mb-3" width="80" height="80">
                <h5>{{ $article->user->name }}</h5>
                @if($article->user->bio)
                    <p class="text-muted">{{ $article->user->bio }}</p>
                @endif
                <div class="d-flex justify-content-center">
                    @if($article->user->isAdmin())
                        <span class="badge bg-danger">Administrator</span>
                    @elseif($article->user->isStaff())
                        <span class="badge bg-warning">Staff</span>
                    @else
                        <span class="badge bg-secondary">User</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-link-45deg me-2"></i>Related Articles
                </h5>
            </div>
            <div class="card-body">
                @if($relatedArticles->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('reader.article.show', $related) }}"
                               class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ Str::limit($related->title, 40) }}</h6>
                                </div>
                                <small class="text-muted">{{ $related->created_at->diffForHumans() }}</small>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No related articles found.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="d-flex justify-content-around">
                    <button class="btn btn-link text-dark p-2">
                        <i class="bi bi-facebook fs-3"></i>
                        <p class="small mb-0">Facebook</p>
                    </button>
                    <button class="btn btn-link text-dark p-2">
                        <i class="bi bi-twitter fs-3"></i>
                        <p class="small mb-0">Twitter</p>
                    </button>
                    <button class="btn btn-link text-dark p-2">
                        <i class="bi bi-linkedin fs-3"></i>
                        <p class="small mb-0">LinkedIn</p>
                    </button>
                    <button class="btn btn-link text-dark p-2">
                        <i class="bi bi-whatsapp fs-3"></i>
                        <p class="small mb-0">WhatsApp</p>
                    </button>
                </div>
                <div class="mt-3">
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ route('reader.article.show', $article) }}" id="shareUrl" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copyButton">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View comments button
    const viewCommentsBtn = document.querySelector('.view-comments-btn');
    const commentsSection = document.querySelector('.comments-section');

    if (viewCommentsBtn) {
        viewCommentsBtn.addEventListener('click', function() {
            commentsSection.style.display = commentsSection.style.display === 'none' ? 'block' : 'none';
            this.textContent = commentsSection.style.display === 'none' ?
                `View all {{ $article->comments->count() }} comments` :
                `Hide comments`;
        });
    }

    // Reply button functionality
    const replyButtons = document.querySelectorAll('.reply-comment-btn');
    const cancelButtons = document.querySelectorAll('.cancel-reply');

    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });

    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = 'none';
        });
    });

    // More/Less content button
    const moreContentBtn = document.querySelector('.more-content-btn');
    const lessContentBtn = document.querySelector('.less-content-btn');
    const fullContent = document.querySelector('.full-content');

    if (moreContentBtn && lessContentBtn && fullContent) {
        moreContentBtn.addEventListener('click', function() {
            fullContent.style.display = 'block';
            this.style.display = 'none';
        });

        lessContentBtn.addEventListener('click', function() {
            fullContent.style.display = 'none';
            moreContentBtn.style.display = 'block';
        });
    }

    // Like button functionality
    const likeBtn = document.querySelector('.like-btn');
    const likeCount = document.querySelector('.like-count');

    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            const articleId = this.getAttribute('data-article-id');
            const heartIcon = this.querySelector('i');

            // Toggle heart icon
            if (heartIcon.classList.contains('bi-heart')) {
                heartIcon.classList.remove('bi-heart');
                heartIcon.classList.add('bi-heart-fill');
                heartIcon.style.color = 'red';

                // Update like count
                if (likeCount) {
                    likeCount.textContent = parseInt(likeCount.textContent) + 1;
                }

                // Send AJAX request to like the article
                fetch(`/reader/articles/${articleId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            } else {
                heartIcon.classList.remove('bi-heart-fill');
                heartIcon.classList.add('bi-heart');
                heartIcon.style.color = '';

                // Update like count
                if (likeCount) {
                    likeCount.textContent = parseInt(likeCount.textContent) - 1;
                }

                // Send AJAX request to unlike the article
                // Note: You'll need to implement an unlike endpoint
            }
        });
    }

    // Copy URL functionality
    const copyButton = document.getElementById('copyButton');
    const shareUrl = document.getElementById('shareUrl');

    if (copyButton && shareUrl) {
        copyButton.addEventListener('click', function() {
            shareUrl.select();
            document.execCommand('copy');

            // Change button text temporarily
            const originalText = this.textContent;
            this.textContent = 'Copied!';

            setTimeout(() => {
                this.textContent = originalText;
            }, 2000);
        });
    }

    // Comment button focus
    const commentBtn = document.querySelector('.comment-btn');
    const commentInput = document.querySelector('.comment-form-section input[name="content"]');

    if (commentBtn && commentInput) {
        commentBtn.addEventListener('click', function() {
            commentInput.focus();
        });
    }

    // Bookmark button functionality
    const bookmarkBtn = document.querySelector('.bookmark-btn');

    if (bookmarkBtn) {
        bookmarkBtn.addEventListener('click', function() {
            const bookmarkIcon = this.querySelector('i');

            // Toggle bookmark icon
            if (bookmarkIcon.classList.contains('bi-bookmark')) {
                bookmarkIcon.classList.remove('bi-bookmark');
                bookmarkIcon.classList.add('bi-bookmark-fill');
            } else {
                bookmarkIcon.classList.remove('bi-bookmark-fill');
                bookmarkIcon.classList.add('bi-bookmark');
            }

            // Send AJAX request to save/unsave the article
            // Note: You'll need to implement a save/unsave endpoint
        });
    }
});
</script>

<style>
.article-content {
    line-height: 1.6;
}

.replies {
    border-left: 2px solid #e9ecef;
    padding-left: 15px;
}

.card {
    border-radius: 8px;
}

.btn-link {
    text-decoration: none;
}

.btn-link:hover {
    text-decoration: underline;
}

.bi-heart-fill {
    color: red;
}
</style>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reply button functionality
    const replyButtons = document.querySelectorAll('.reply-btn');
    const cancelButtons = document.querySelectorAll('.cancel-reply');

    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });

    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = 'none';
        });
    });
});
</script>

<style>
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.replies {
    border-left: 2px solid #e9ecef;
    padding-left: 15px;
}

.reply-btn, .cancel-reply {
    font-size: 0.8rem;
}
</style>


