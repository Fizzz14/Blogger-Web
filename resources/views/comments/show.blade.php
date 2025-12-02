
@extends('template.app')

@section('title', 'Comment Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-chat-dots me-2"></i>Comment Details
    </h1>
    <div>
        <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Comments
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Comment Information</h5>
        <div>
            @if ($comment->is_approved)
                <form action="{{ route('admin.comments.unapprove', $comment) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-x-circle me-1"></i>Unapprove
                    </button>
                </form>
            @else
                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-check-circle me-1"></i>Approve
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.comments.edit', $comment) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this comment?')">
                    <i class="bi bi-trash me-1"></i>Delete
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h6>Article</h6>
                <p>
                    <a href="{{ route('articles.show', $comment->article) }}" target="_blank">
                        {{ $comment->article->title }}
                    </a>
                </p>
            </div>
            <div class="col-md-6">
                <h6>User</h6>
                <p>{{ $comment->user->name }} ({{ $comment->user->email }})</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <h6>Status</h6>
                <p>
                    @if ($comment->is_approved)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-warning">Pending</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <h6>Date</h6>
                <p>{{ $comment->created_at->format('F d, Y 	 h:i A') }}</p>
            </div>
        </div>

        @if ($comment->parent)
            <div class="mb-3">
                <h6>Replying To</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="mb-0">{{ $comment->parent->content }}</p>
                        <small class="text-muted">By {{ $comment->parent->user->name }} on {{ $comment->parent->created_at->format('F d, Y 	 h:i A') }}</small>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-3">
            <h6>Content</h6>
            <div class="card">
                <div class="card-body">
                    <p>{{ $comment->content }}</p>
                </div>
            </div>
        </div>

        @if ($comment->replies->count() > 0)
            <div class="mb-3">
                <h6>Replies ({{ $comment->replies->count() }})</h6>
                <div class="list-group">
                    @foreach ($comment->replies as $reply)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">{{ $reply->user->name }}</h6>
                                <small>{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $reply->content }}</p>
                            <div>
                                @if ($reply->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
