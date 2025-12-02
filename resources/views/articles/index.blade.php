@extends('template.app')

@section('title', 'My Articles')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2 gradient-text">
            <i class="bi bi-journal-text me-2"></i>My Articles
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('articles.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-2"></i>New Article
            </a>
            <div class="btn-group me-2">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('articles.export') }}">Export as Excel</a></li>
                </ul>
            </div>
            <div class="btn-group me-2">
                </button>
                <ul class="dropdown-menu">
                            @csrf
                            <div class="mb-2">
                                <label for="file" class="form-label">Choose Excel File</label>
                                <input class="form-control form-control-sm" type="file" name="file" id="file" required accept=".xlsx,.xls,.csv">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary w-100">Import</button>
                        </form>
                    </li>
                </ul>
            </div>
            <a href="{{ route('articles.trash') }}" class="btn btn-outline-secondary">
                <i class="bi bi-trash me-2"></i>Trash
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-ul me-2"></i>Articles List
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
                                <th>Status</th>
                                <th>Views</th>
                                <th>Likes</th>
                                <th>Created</th>
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
                                        <span class="badge" style="background-color: {{ $article->category->color }};">
                                            {{ $article->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="bi bi-eye me-1"></i>{{ $article->view_count }}
                                    </td>
                                    <td>
                                        <i class="bi bi-heart me-1"></i>{{ $article->like_count }}
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                            <a href="{{ route('articles.edit', $article) }}"
                                               class="btn btn-warning me-2 rounded-pill" title="Edit">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill" onclick="return confirm('Are you sure you want to delete this')" title="Delete User">
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
                    <i class="bi bi-journal-text display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No Articles Yet</h4>
                    <p class="text-muted">Start writing your first article and share your thoughts with the world.</p>
                    <a href="{{ route('articles.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create Your First Article
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection