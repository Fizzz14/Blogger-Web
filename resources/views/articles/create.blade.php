@extends('template.app')

@section('title', 'Create New Article')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-plus-circle me-2"></i>Create New Article
    </h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Article Content</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Article Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}" required>
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
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="12" required
                                  placeholder="Write your article content here...">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured Image (Optional)</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                               id="featured_image" name="featured_image" accept="image/*">
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Max file size: 5MB. Supported formats: JPG, PNG, GIF.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Save Article
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
                    <i class="bi bi-info-circle me-2"></i>Writing Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="bi bi-lightbulb me-2"></i>Tips for Great Articles:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Write clear and engaging titles</li>
                        <li>Use proper formatting and paragraphs</li>
                        <li>Include relevant images when possible</li>
                        <li>Proofread before publishing</li>
                        <li>Add a compelling excerpt</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="bi bi-clock me-2"></i>Status Information:</h6>
                    <ul class="mb-0 ps-3">
                        <li><strong>Draft:</strong> Save for later editing</li>
                        <li><strong>Published:</strong> Make article public immediately</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple character counter for excerpt
    document.getElementById('excerpt').addEventListener('input', function(e) {
        const maxLength = 500;
        const currentLength = e.target.value.length;
        const counter = document.getElementById('excerpt-counter') ||
                       (function() {
                           const div = document.createElement('div');
                           div.className = 'form-text';
                           div.id = 'excerpt-counter';
                           e.target.parentNode.appendChild(div);
                           return div;
                       })();

        counter.textContent = `${currentLength}/${maxLength} characters`;

        if (currentLength > maxLength) {
            counter.className = 'form-text text-danger';
        } else {
            counter.className = 'form-text text-muted';
        }
    });
</script>
@endpush
