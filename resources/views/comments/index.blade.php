
@extends('template.app')

@section('title', 'Manage Comments')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-chat-dots me-2"></i>Comments Management
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-file-earmark-excel me-1"></i>Export
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('staff.comments.export') }}">Export as Excel</a></li>
            </ul>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i>All Comments
        </h5>
    </div>
    <div class="card-body">
        @if ($comments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th>User</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    <a href="{{ route('articles.show', $comment->article) }}" target="_blank">
                                        {{ Str::limit($comment->article->title, 50) }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </div>
                                        {{ $comment->user->name }}
                                    </div>
                                </td>
                                <td>
                                    {{ Str::limit($comment->content, 100) }}
                                    @if ($comment->parent)
                                        <span class="badge bg-info ms-1">Reply</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($comment->is_approved)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-outline-primary me-2 rounded-pill" title="View">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.comments.edit', $comment) }}"  class="btn btn-warning me-2 rounded-pill">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ route{'admin.comments.'} }}"></a>
                                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this comment?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-chat-dots display-1 text-muted"></i>
                <h4 class="text-muted mt-3">No Comments Yet</h4>
                <p class="text-muted">Comments will appear here once users start interacting with articles.</p>
            </div>
        @endif
    </div>
</div>
@endsection
