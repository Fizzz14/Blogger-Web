@extends('template.staff')

@section('title', 'Staff Dashboard')

@section('staff_content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('staff.comments.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-chat-left-text me-1"></i> Manage Comments
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Articles
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_articles'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-journal-text fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Published Articles
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['published_articles'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Comments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_comments'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-left-text fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Comments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['pending_comments'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Comments -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recent Comments</h6>
                <a href="{{ route('staff.comments.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @php
                    $recentComments = App\Models\Comment::with(['user', 'article'])
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @if($recentComments->count() > 0)
                    @foreach($recentComments as $comment)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-1">{{ Str::limit($comment->content, 50) }}</h6>
                                @if($comment->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                            <div class="small text-muted">
                                By {{ $comment->user->name }} on {{ $comment->article->title }}
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('staff.comments.show', $comment) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                @if(!$comment->is_approved)
                                    <form action="{{ route('staff.comments.approve', $comment) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check"></i> Approve
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No comments found.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Articles -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recent Articles</h6>
                <a href="{{ route('articles.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @php
                    $recentArticles = App\Models\Article::with(['user', 'category'])
                        ->latest()
                        ->take(5)
                        ->get();
                @endphp

                @if($recentArticles->count() > 0)
                    @foreach($recentArticles as $article)
                        <div class="mb-3 pb-3 border-bottom">
                            <h6 class="mb-1">{{ $article->title }}</h6>
                            <div class="small text-muted">
                                By {{ $article->user->name }} • {{ $article->created_at->format('M d, Y') }}
                            </div>
                            <div class="mt-2">
                                <span class="badge me-1" style="background-color: {{ $article->category->color }};">
                                    {{ $article->category->name }}
                                </span>
                                <span class="badge bg-secondary me-1">{{ $article->view_count }} views</span>
                                <span class="badge bg-danger">{{ $article->like_count }} likes</span>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No articles found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
