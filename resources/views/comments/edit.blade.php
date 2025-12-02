
@extends('template.app')

@section('title', 'Edit Comment')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-chat-dots me-2"></i>Edit Comment
    </h1>
    <div>
        <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Comment
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Edit Comment</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.comments.update', $comment) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="article" class="form-label">Article</label>
                <p>{{ $comment->article->title }}</p>
            </div>

            <div class="mb-3">
                <label for="user" class="form-label">User</label>
                <p>{{ $comment->user->name }} ({{ $comment->user->email }})</p>
            </div>

            @if ($comment->parent)
                <div class="mb-3">
                    <label class="form-label">Replying To</label>
                    <div class="card bg-light">
                        <div class="card-body">
                            <p class="mb-0">{{ $comment->parent->content }}</p>
                            <small class="text-muted">By {{ $comment->parent->user->name }} on {{ $comment->parent->created_at->format('F d, Y 	 h:i A') }}</small>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $comment->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_approved" name="is_approved" value="1" {{ old('is_approved', $comment->is_approved) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_approved">
                        Approved
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-outline-secondary me-2">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
