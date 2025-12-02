@extends('template.admin')

@section('title', 'Manage Comments')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Comments</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <a href="{{ route('admin.comments.export') }}" class="btn btn-default btn-sm">
                                <i class="fas fa-download"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="comments-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Article</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>
                                        <a href="{{ route('articles.show', $comment->article) }}" target="_blank">
                                            {{ Str::limit($comment->article->title, 30) }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $comment->user->getAvatarUrl() }}" alt="{{ $comment->user->name }}"
                                                 class="rounded-circle me-2" width="30" height="30">
                                            {{ $comment->user->name }}
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($comment->content, 50) }}</td>
                                    <td>
                                        @if($comment->is_approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $comment->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-info me-2 rounded-pill">Detail
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.comments.edit', $comment) }}"  class="btn btn-warning me-2 rounded-pill">Edit
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger rounded-pill">Delete
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
    $("#comments-table").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true
    }).buttons().container().appendTo('#comments-table_wrapper .col-md-6:eq(0)');
});
</script>
@endpush
