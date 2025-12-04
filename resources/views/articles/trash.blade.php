@extends('template.app')

@section('title', 'Trashed Articles')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2 gradient-text">
            <i class="bi bi-trash me-2"></i>Trashed Articles
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-2"></i>Back to Articles
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-ul me-2"></i>Deleted Articles
            </h5>
        </div>
        <div class="card-body">
            @if ($articles->count() > 0)
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
                            @foreach ($articles as $article)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($article->title, 50) }}</strong>
                                        @if ($article->featured_image)
                                            <i class="bi bi-image text-primary ms-1" title="Has featured image"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($article->category)
                                            <span class="badge" style="background-color: {{ $article->category->color }};">
                                                {{ $article->category->name }}
                                            </span>
                                        @else
                                            <span class="text-muted">No category</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($article->user)
                                            {{ $article->user->name }}
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $article->deleted_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('articles.restore', $article->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm rounded-pill me-2" title="Restore">
                                                    <i class="bi bi-arrow-clockwise"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('articles.forceDelete', $article->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Are you sure you want to permanently delete this article? This action cannot be undone.')" title="Delete Permanently">
                                                    <i class="bi bi-trash"></i> Delete 
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
                    <i class="bi bi-trash display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No Trashed Articles</h4>
                    <p class="text-muted">Your trash is empty. Articles you delete will appear here.</p>
                    <a href="{{ route('articles.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Articles
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
