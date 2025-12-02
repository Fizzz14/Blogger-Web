@extends('template.app')

@section('title', 'Create New Category')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2 gradient-text">
        <i class="bi bi-plus-circle me-2"></i>Create New Category
    </h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Categories
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Category Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">Category Color</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('color') is-invalid @enderror"
                                   id="color" name="color" value="{{ old('color', '#6366f1') }}" 
                                   pattern="^#[0-9A-Fa-f]{6}$" required>
                            <span class="input-group-text">
                                <div id="color-preview" style="width: 24px; height: 24px; background-color: {{ old('color', '#6366f1') }}; border-radius: 4px;"></div>
                            </span>
                        </div>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter a hex color code (e.g., #6366f1, #10b981)</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">A short description of what this category is about.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Save Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
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
                    <i class="bi bi-info-circle me-2"></i>Category Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="bi bi-lightbulb me-2"></i>Good Categories:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Use descriptive names</li>
                        <li>Choose distinct colors</li>
                        <li>Keep them organized</li>
                        <li>Consider your content structure</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="bi bi-palette me-2"></i>Color Tips:</h6>
                    <ul class="mb-0 ps-3">
                        <li>Use good contrast with text</li>
                        <li>Choose colors that represent the category</li>
                        <li>Don't use similar colors for different categories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update color preview when input changes
    document.getElementById('color').addEventListener('input', function(e) {
        const colorValue = e.target.value;
        const colorPreview = document.getElementById('color-preview');

        // Update preview if it's a valid hex color
        if (/^#[0-9A-Fa-f]{6}$/.test(colorValue)) {
            colorPreview.style.backgroundColor = colorValue;
        }
    });
</script>
@endpush
