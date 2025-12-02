@extends('template.staff')

@section('title', $article->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Article Card -->
        <div class="card mb-4 shadow-sm">
            <!-- Article Header -->
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="{{ $article->user->getAvatarUrl() }}" alt="{{ $article->user->name }}"
                             class="rounded-circle me-3" width="40" height="40">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $article->user->name }}</h6>
                            <small class="text-muted">{{ $article->published_at ? $article->published_at->format('M d, Y') : 'Not published' }} · {{ $article->category->name }}</small>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-{{ $article->status === 'published' ? 'success' : 'secondary' }}">
                            {{ $article->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Article Title -->
            <div class="px-3 pt-2">
                <h4 class="fw-bold">{{ $article->title }}</h4>
                @if($article->excerpt)
                <p class="text-muted">{{ $article->excerpt }}</p>
                @endif
            </div>

            <!-- Featured Image -->
            @if($article->featured_image)
            <div class="card-body p-0">
                <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                     class="img-fluid w-100" style="max-height: 500px; object-fit: cover;">
            </div>
            @endif

            <!-- Article Stats -->
            <div class="card-body pt-3 pb-2">
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="me-3"><i class="bi bi-eye"></i> {{ $article->view_count }} views</span>
                        <span class="me-3"><i class="bi bi-heart"></i> {{ $article->like_count }} likes</span>
                        <span><i class="bi bi-chat"></i> {{ $article->comments->count() }} comments</span>
                    </div>
                    <div>
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article Content -->
            <div class="card-body pt-0">
                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Comments ({{ $article->comments->count() }})</h5>
            </div>
            <div class="card-body">
                @if($article->comments->count() > 0)
                    @foreach($article->comments as $comment)
                        <div class="comment mb-3 pb-3 border-bottom">
                            <div class="d-flex">
                                <img src="{{ $comment->user->getAvatarUrl() }}"
                                     alt="{{ $comment->user->name }}"
                                     class="rounded-circle me-2" width="32" height="32">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-0 fw-bold">{{ $comment->user->name }}</h6>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 mt-1">{{ $comment->content }}</p>

                                    <!-- Comment Actions -->
                                    <div class="mt-2">
                                        <a href="{{ route('staff.comments.show', $comment) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                        <a href="{{ route('staff.comments.edit', $comment) }}" class="btn btn-sm btn-outline-secondary">
                                            Edit
                                        </a>
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No comments yet.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Article Actions -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Article Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('articles.edit', $article) }}" class="btn btn-primary">
                        Edit Article
                    </a>

                    @if($article->status === 'published')
                        <a href="#" class="btn btn-warning">
                            Unpublish
                        </a>
                    @else
                        <a href="#" class="btn btn-success">
                            Publish
                        </a>
                    @endif

                    <form action="{{ route('articles.destroy', $article) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this article?')">
                            Delete Article
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Article Details -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Article Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td class="text-muted">ID:</td>
                        <td>{{ $article->id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Slug:</td>
                        <td>{{ $article->slug }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status:</td>
                        <td>
                            <span class="badge bg-{{ $article->status === 'published' ? 'success' : 'secondary' }}">
                                {{ $article->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Category:</td>
                        <td>{{ $article->category->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Author:</td>
                        <td>{{ $article->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Created:</td>
                        <td>{{ $article->created_at->format('M d, Y') }}</td>
                    </tr>
                    @if($article->published_at)
                    <tr>
                        <td class="text-muted">Published:</td>
                        <td>{{ $article->published_at->format('M d, Y') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="text-muted">Views:</td>
                        <td>{{ $article->view_count }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Likes:</td>
                        <td>{{ $article->like_count }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
