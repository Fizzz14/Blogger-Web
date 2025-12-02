@extends('template.app')

@section('title', $article->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Article Header -->
        <div class="card mb-4">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Articles</a></li>
                        <li class="breadcrumb-item active">{{ Str::limit($article->title, 30) }}</li>
                    </ol>
                </nav>

                <h1 class="gradient-text mb-3">{{ $article->title }}</h1>

                <div class="d-flex flex-wrap align-items-center text-muted mb-3">
                    <div class="d-flex align-items-center me-4 mb-2">
                        <img src="{{ $article->user->getAvatarUrl() }}" alt="{{ $article->user->name }}"
                             class="rounded-circle me-2" width="32" height="32">
                        <span>{{ $article->user->name }}</span>
                    </div>
                    <div class="d-flex align-items-center me-4 mb-2">
                        <i class="bi bi-calendar me-1"></i>
                        <span>{{ $article->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center me-4 mb-2">
                        <i class="bi bi-eye me-1"></i>
                        <span>{{ $article->view_count }} views</span>
                    </div>
                    <div class="d-flex align-items-center me-4 mb-2">
                        <i class="bi bi-heart me-1"></i>
                        <span>{{ $article->like_count }} likes</span>
                    </div>
                    <div class="mb-2">
                        <span class="badge" style="background-color: {{ $article->category->color }};">
                            {{ $article->category->name }}
                        </span>
                    </div>
                </div>

                <!-- Action Buttons -->
                @auth
                    @if(Auth::id() === $article->user_id || Auth::user()->isAdmin() || Auth::user()->isStaff())
                    <div class="btn-group mb-3">
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to move this article to trash?')">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Featured Image -->
        @if($article->featured_image)
        <div class="card mb-4">
            <div class="card-body p-0">
                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                     class="img-fluid rounded" style="width: 100%; max-height: 400px; object-fit: cover;">
            </div>
        </div>
        @endif

        <!-- Excerpt -->
        @if($article->excerpt)
        <div class="card mb-4">
            <div class="card-body">
                <div class="alert alert-info mb-0">
                    <h6 class="alert-heading">
                        <i class="bi bi-quote me-2"></i>Summary
                    </h6>
                    {{ $article->excerpt }}
                </div>
            </div>
        </div>
        @endif

        <!-- Article Content -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
        </div>

        <!-- Like Button -->
        @auth
        <div class="card mb-4">
            <div class="card-body text-center">
                <form action="{{ route('reader.article.like', $article) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-lg">
                        <i class="bi bi-heart-fill me-2"></i>Like this Article
                        <span class="badge bg-danger ms-2">{{ $article->like_count }}</span>
                    </button>
                </form>
            </div>
        </div>
        @endauth

        <!-- Comments Section -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-chat-left-text me-2"></i>
                    Comments
                    <span class="badge bg-primary ms-2">{{ $article->comments->count() }}</span>
                </h5>
            </div>
            <div class="card-body">
                <!-- Add Comment Form -->
                @auth
                <form action="{{ route('comments.store', $article) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="content" class="form-label">Add a Comment</label>
                        <textarea class="form-control" id="content" name="content" rows="3"
                                  placeholder="Share your thoughts..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>
                <hr>
                @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}" class="alert-link">Login</a> to post a comment.
                </div>
                <hr>
                @endauth

                <!-- Comments List -->
                @if($article->comments->count() > 0)
                    <div class="comments-list">
                        @foreach($article->comments as $comment)
                            <div class="comment mb-3 pb-3 border-bottom">
                                <div class="d-flex">
                                    <img src="{{ $comment->user->getAvatarUrl() }}"
                                         alt="{{ $comment->user->name }}"
                                         class="rounded-circle me-3" width="40" height="40">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            @auth
                                                @if(Auth::id() === $comment->user_id || Auth::user()->isAdmin() || Auth::user()->isStaff())
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Delete this comment?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            @endauth
                                        </div>
                                        <p class="mb-0 mt-2">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-chat-left-text display-4 text-muted"></i>
                        <p class="text-muted mt-3">No comments yet. Be the first to comment!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Article Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>Article Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'secondary') }} float-end">
                        {{ ucfirst($article->status) }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Category:</strong>
                    <span class="badge float-end" style="background-color: {{ $article->category->color }};">
                        {{ $article->category->name }}
                    </span>
                </div>
                <div class="mb-3">
                    <strong>Published:</strong>
                    <span class="float-end">
                        @if($article->published_at)
                            {{ $article->published_at->format('M d, Y') }}
                        @else
                            <span class="text-muted">Not published</span>
                        @endif
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
        <div class="card mb-4">
            <div class="card-header">
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-link-45deg me-2"></i>Related Articles
                </h5>
            </div>
            <div class="card-body">
                @php
                    $relatedArticles = App\Models\Article::where('category_id', $article->category_id)
                        ->where('id', '!=', $article->id)
                        ->published()
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @if($relatedArticles->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('articles.show', $related) }}"
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

<style>
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.comments-list .comment:last-child {
    border-bottom: none !important;
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
</style>
@endsection
