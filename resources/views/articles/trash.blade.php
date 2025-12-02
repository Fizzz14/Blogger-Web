@extends('template.app')

@section('title', 'Trash - Articles')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-trash me-2"></i>Trash
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('articles.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Articles
        </a>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-trash me-2"></i>Deleted Articles
            <span class="badge bg-danger ms-2">{{ $articles->count() }}</span>
        </h5>
    </div>
    <div class="card-body">
        @if($articles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($article->featured_image)
                                        <img src="{{ Storage::url($article->featured_image) }}"
                                             alt="Featured" class="rounded me-2" width="40" height="40"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="bi bi-image text-light"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong class="d-block">{{ Str::limit($article->title, 50) }}</strong>
                                        <small class="text-muted">
                                            Views: {{ $article->view_count }} |
                                            Likes: {{ $article->like_count }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $article->category->color }};">
                                    {{ $article->category->name }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $article->user->name }}</small>
                            </td>
                            <td>
                                <small class="text-muted" title="{{ $article->deleted_at->format('M d, Y H:i') }}">
                                    {{ $article->deleted_at->diffForHumans() }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('articles.restore', $article->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success" title="Restore">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                        </button>
                                    </form>

                                    @if(Auth::user()->isAdmin())
                                    <form action="{{ route('articles.forceDelete', $article->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Permanently Delete"
                                                onclick="return confirm('Are you sure you want to permanently delete this article? This action cannot be undone.')">
                                            <i class="bi bi-trash-fill me-1"></i>Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        @else
            <div class="text-center py-5">
                <i class="bi bi-trash display-1 text-muted"></i>
                <h4 class="text-muted mt-3">Trash is Empty</h4>
                <p class="text-muted">No articles have been moved to trash yet.</p>
                <a href="{{ route('articles.index') }}" class="btn btn-primary">
                    <i class="bi bi-journal-text me-2"></i>Back to Articles
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
