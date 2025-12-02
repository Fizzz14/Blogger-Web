@extends('template.admin')

@section('title', 'Manage Articles - Admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Articles</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <a href="{{ route('admin.articles.export') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-download"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
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
    $("#articles-table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true
    }).buttons().container().appendTo('#articles-table_wrapper .col-md-6:eq(0)');
});
</script>
@endpush
