@extends('template.app')

@section('title', 'Edit Category')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        Edit Category
    </h1>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color', $category->color) }}" required>
                            <input type="color" class="form-control form-control-color" id="colorPicker" value="{{ old('color', $category->color) }}" title="Choose a color">
                        </div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Choose a color to represent this category</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            Back to Categories
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Preview
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Category Badge Preview</label>
                    <div class="p-3 border rounded">
                        <span class="badge fs-5 p-2" id="previewBadge" style="background-color: {{ $category->color }};">
                            {{ $category->name }}
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Article Card Preview</label>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Sample Article Title</h5>
                            <div class="mb-2">
                                <span class="badge" id="articleBadge" style="background-color: {{ $category->color }};">
                                    {{ $category->name }}
                                </span>
                            </div>
                            <p class="card-text">This is how your category will appear on article cards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('previewBadge').textContent = this.value || 'Category Name';
        document.getElementById('articleBadge').textContent = this.value || 'Category Name';
    });

    document.getElementById('color').addEventListener('input', function() {
        const color = this.value;
        document.getElementById('colorPicker').value = color;
        document.getElementById('previewBadge').style.backgroundColor = color;
        document.getElementById('articleBadge').style.backgroundColor = color;
    });

    document.getElementById('colorPicker').addEventListener('input', function() {
        const color = this.value;
        document.getElementById('color').value = color;
        document.getElementById('previewBadge').style.backgroundColor = color;
        document.getElementById('articleBadge').style.backgroundColor = color;
    });
</script>
@endpush