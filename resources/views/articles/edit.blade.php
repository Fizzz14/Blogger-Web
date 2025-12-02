@extends('template.app')

@section('title', 'Edit Article')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-pencil me-2"></i>Edit Article
    </h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Article Content</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Article Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $article->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No categories available</option>
                                    @endif
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if(!isset($categories) || $categories->count() === 0)
                                    <div class="form-text text-warning">No categories available. <a href="{{ route('categories.create') }}">Create a category</a> first.</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                    <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                  id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="12" required>{{ old('content', $article->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        @if($article->featured_image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($article->featured_image) }}" alt="Current featured image"
                                     class="img-fluid rounded" style="max-height: 200px;">
                                <div class="form-text">Current featured image</div>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                               id="featured_image" name="featured_image" accept="image/*">
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Update Article
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i>Article Stats
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Views:</strong>
                    <span class="float-end">{{ $article->view_count }}</span>
                </div>
                <div class="mb-3">
                    <strong>Likes:</strong>
                    <span class="float-end">{{ $article->like_count }}</span>
                </div>
                <div class="mb-3">
                    <strong>Created:</strong>
                    <span class="float-end">{{ $article->created_at->format('M d, Y') }}</span>
                </div>
                <div>
                    <strong>Last Updated:</strong>
                    <span class="float-end">{{ $article->updated_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
