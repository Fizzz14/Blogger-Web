@extends('template.staff')

@section('title', 'Comment Details')

@section('staff_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <!-- Main Comment -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Comment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('staff.comments.datatables') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="comment mb-4">
                        <div class="d-flex">
                            <img src="{{ $comment->user->getAvatarUrl() }}" alt="{{ $comment->user->name }}"
                                 class="rounded-circle me-3" width="50" height="50">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5>{{ $comment->user->name }}</h5>
                                        <small class="text-muted">{{ $comment->created_at->format('M d, Y H:i') }}</small>
                                        @if($comment->parent)
                                            <div class="mt-1">
                                                <small class="text-info">Replying to comment by {{ $comment->parent->user->name }}</small>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        @if($comment->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-3 p-3 bg-light rounded">
                                    {{ $comment->content }}
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        On article: <a href="{{ route('articles.show', $comment->article) }}" target="_blank">{{ $comment->article->title }}</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('staff.comments.edit', $comment) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Comment
                            </a>
                        </div>
                        <div>
                            @if($comment->is_approved)
                                <form action="{{ route('staff.comments.unapprove', $comment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Unapprove
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('staff.comments.approve', $comment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('staff.comments.destroy', $comment) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this comment?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replies -->
            @if($comment->replies->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Replies ({{ $comment->replies->count() }})</h4>
                    </div>
                    <div class="card-body">
                        @foreach($comment->replies as $reply)
                            <div class="comment mb-3 pb-3 border-bottom">
                                <div class="d-flex">
                                    <img src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->name }}"
                                         class="rounded-circle me-3" width="40" height="40">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6>{{ $reply->user->name }}</h6>
                                                <small class="text-muted">{{ $reply->created_at->format('M d, Y H:i') }}</small>
                                            </div>
                                            <div>
                                                @if($reply->is_approved)
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2 p-2 bg-light rounded">
                                            {{ $reply->content }}
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.comments.show', $reply) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                            <a href="{{ route('admin.comments.edit', $reply) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.comments.destroy', $reply) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Comment Info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Comment Information</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $comment->id }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($comment->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $comment->created_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Updated:</th>
                            <td>{{ $comment->updated_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- User Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">User Information</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $comment->user->getAvatarUrl() }}" alt="{{ $comment->user->name }}"
                         class="rounded-circle mb-3" width="80" height="80">
                    <h5>{{ $comment->user->name }}</h5>
                    <p class="text-muted">{{ $comment->user->email }}</p>
                    <div class="d-flex justify-content-center">
                        @if($comment->user->isAdmin())
                            <span class="badge bg-danger">Administrator</span>
                        @elseif($comment->user->isStaff())
                            <span class="badge bg-warning">Staff</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Article Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Article Information</h4>
                </div>
                <div class="card-body">
                    <h6>{{ $comment->article->title }}</h6>
                    <p class="text-muted small">By {{ $comment->article->user->name }}</p>
                    <p class="text-muted small">Published: {{ $comment->article->published_at->format('M d, Y') }}</p>
                    <a href="{{ route('articles.show', $comment->article) }}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i> View Article
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
