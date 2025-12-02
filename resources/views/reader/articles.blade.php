@extends('template.app')

@section('title', 'Semua Artikel - BACAKUY')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="h3 gradient-text mb-0">Semua Artikel</h1>
                <p class="text-muted">Jelajahi semua artikel menarik di BACAKUY</p>

                <!-- Search Form -->
                <form action="{{ route('reader.search') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control"
                               placeholder="Cari artikel..." value="{{ request('q') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Category Filter -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <a href="{{ route('reader.articles') }}"
                       class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('reader.articles.category', $category) }}"
                       class="btn btn-sm {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach($articles as $article)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card article-card h-100">
            @if($article->featured_image)
            <img src="{{ Storage::url($article->featured_image) }}"
                 class="card-img-top" alt="{{ $article->title }}"
                 style="height: 200px; object-fit: cover;">
            @else
            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center"
                 style="height: 200px;">
                <i class="bi bi-image text-white fs-1"></i>
            </div>
            @endif

            <div class="card-body">
                <span class="badge mb-2" style="background-color: {{ $article->category->color }};">
                    {{ $article->category->name }}
                </span>
                <h5 class="card-title">
                    <a href="{{ route('reader.article.show', $article) }}" class="text-decoration-none text-white">
                        {{ Str::limit($article->title, 70) }}
                    </a>
                </h5>
                <p class="card-text text-muted">
                    {{ Str::limit($article->excerpt ?: strip_tags($article->content), 120) }}
                </p>
            </div>

            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ $article->user->getAvatarUrl() }}"
                             alt="{{ $article->user->name }}"
                             class="rounded-circle me-2" width="24" height="24">
                        <small class="text-muted">{{ $article->user->name }}</small>
                    </div>
                    <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted">
                        <i class="bi bi-eye me-1"></i>{{ $article->view_count }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-heart me-1"></i>{{ $article->like_count }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-chat me-1"></i>{{ $article->comments_count ?? 0 }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
@if($articles->hasPages())
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>
@endif

<style>
.article-card {
    transition: all 0.3s ease;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}
</style>
@endsection
