@extends('template.admin')

@section('title', 'Manage Articles - Admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Articles</h3>
                    <div class="card-tools d-flex justify-content-between w-100">
                        <div class="btn-group">
                            <a href="{{ route('admin.articles.export') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-download"></i> Export
                            </a>
                        </div>
                        <div class="input-group" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search articles...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category-filter">Filter by Category</label>
                                <select class="form-control" id="category-filter">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status-filter">Filter by Status</label>
                                <select class="form-control" id="status-filter">
                                    <option value="">All Status</option>
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button id="reset-filters" class="btn btn-secondary w-100">
                                <i class="fas fa-sync-alt me-2"></i>Reset Filters
                            </button>
                        </div>
                    </div>
                    <table id="articles-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Likes</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{ $article->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.articles.show', $article) }}" target="_blank">
                                            {{ Str::limit($article->title, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $article->category->color }};">
                                            {{ $article->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $article->user->getAvatarUrl() }}" alt="{{ $article->user->name }}"
                                                 class="rounded-circle me-2" width="30" height="30">
                                            {{ $article->user->name }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($article->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $article->view_count }}</td>
                                    <td>{{ $article->like_count }}</td>
                                    <td>{{ $article->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-info btn-sm">Detail
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning btn-sm">Edit
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this article?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
@endsection

@push('scripts')
<script>
$(function () {
    var table = $("#articles-table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true,
        "dom": 'lrtip', // Remove default search
        "language": {
            "search": "",
            "searchPlaceholder": "Search articles..."
        }
    }).buttons().container().appendTo('#articles-table_wrapper .col-md-6:eq(0)');
    
    // Custom search functionality
    $('input[name="table_search"]').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Category filter
    $('#category-filter').on('change', function() {
        table.column(2).search($(this).val()).draw();
    });
    
    // Status filter
    $('#status-filter').on('change', function() {
        table.column(4).search($(this).val()).draw();
    });
    
    // Reset filters
    $('#reset-filters').on('click', function() {
        $('#category-filter').val('');
        $('#status-filter').val('');
        $('input[name="table_search"]').val('');
        table.search('').columns().search('').draw();
    });
});
</script>
@endpush
