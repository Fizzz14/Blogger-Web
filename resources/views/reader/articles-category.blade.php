@extends('template.app')

@section('title', $category->name . ' Articles')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Category Header -->
        <div class="card mb-4">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('reader.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reader.articles') }}">Articles</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }}</li>
                    </ol>
                </nav>

                <h1 class="gradient-text mb-3">{{ $category->name }} Articles</h1>
                <p class="text-muted">{{ $articles->count() }} articles in this category</p>
            </div>
        </div>

        <!-- Articles List -->
        <div class="row">
            @forelse($articles as $article)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        @if($article->featured_image)
                            <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ Str::limit($article->title, 50) }}</h5>
                            <p class="card-text text-muted small">
                                By {{ $article->user->name }} • {{ $article->published_at->format('M d, Y') }}
                            </p>
                            <p class="card-text">{{ Str::limit($article->excerpt ?: strip_tags($article->content), 100) }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge" style="background-color: {{ $article->category->color }};">
                                        {{ $article->category->name }}
                                    </span>
                                    <div class="text-muted small">
                                        <i class="bi bi-eye me-1"></i>{{ $article->view_count }}
                                        <i class="bi bi-heart ms-2 me-1"></i>{{ $article->like_count }}
                                    </div>
                                </div>
                                <a href="{{ route('reader.article.show', $article) }}" class="btn btn-primary mt-2">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-journal-text display-1 text-muted"></i>
                        <h3 class="mt-3">No articles found</h3>
                        <p class="text-muted">There are no articles in this category yet.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Categories -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-tags me-2"></i>Categories
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($categories as $cat)
                        <a href="{{ route('reader.articles.category', $cat) }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $cat->id === $category->id ? 'active' : '' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $cat->articles()->published()->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Popular Articles -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-fire me-2"></i>Popular Articles
                </h5>
            </div>
            <div class="card-body">
                @php
                    $popularArticles = App\Models\Article::with(['user', 'category'])
                        ->where('status', 'published')
                        ->orderBy('view_count', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @if($popularArticles->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($popularArticles as $popular)
                            <a href="{{ route('reader.article.show', $popular) }}"
                               class="list-group-item list-group-item-action bg-transparent text-light border-secondary">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ Str::limit($popular->title, 40) }}</h6>
                                </div>
                                <small class="text-muted">{{ $popular->created_at->diffForHumans() }}</small>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No popular articles found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
