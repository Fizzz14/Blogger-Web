@extends('template.staff')

@section('title', 'Edit Comment')

@section('staff_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Comment</h3>
                    <div class="card-tools">
                        <a href="{{ route('staff.comments.show', $comment) }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Comment
                        </a>
                    </div>
                </div>
                <form action="{{ route('staff.comments.update', $comment) }}" method="POST">
                    @method("PUT")
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="content">Comment Content</label>
                                    <textarea class="form-control" id="content" name="content" rows="5" required>{{ $comment->content }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="is_approved" name="is_approved" value="1" {{ $comment->is_approved ? 'checked' : '' }}>
                                        <label for="is_approved">Approved</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('staff.comments.show', $comment) }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Comment Info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Comment Information</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $comment->id }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($comment->is_approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created:</th>
                            <td>{{ $comment->created_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Updated:</th>
                            <td>{{ $comment->updated_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- User Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">User Information</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $comment->user->getAvatarUrl() }}" alt="{{ $comment->user->name }}"
                         class="rounded-circle mb-3" width="80" height="80">
                    <h5>{{ $comment->user->name }}</h5>
                    <p class="text-muted">{{ $comment->user->email }}</p>
                    <div class="d-flex justify-content-center">
                        @if($comment->user->isAdmin())
                            <span class="badge bg-danger">Administrator</span>
                        @elseif($comment->user->isStaff())
                            <span class="badge bg-warning">Staff</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Article Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Article Information</h4>
                </div>
                <div class="card-body">
                    <h6>{{ $comment->article->title }}</h6>
                    <p class="text-muted small">By {{ $comment->article->user->name }}</p>
                    <p class="text-muted small">Published: {{ $comment->article->published_at->format('M d, Y') }}</p>
                    <a href="{{ route('articles.show', $comment->article) }}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i> View Article
                    </a>
                </div>
            </div>

            <!-- Parent Comment -->
            @if($comment->parent)
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">Replying To</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <img src="{{ $comment->parent->user->getAvatarUrl() }}" alt="{{ $comment->parent->user->name }}"
                             class="rounded-circle me-2" width="40" height="40">
                        <div class="flex-grow-1">
                            <h6>{{ $comment->parent->user->name }}</h6>
                            <small class="text-muted">{{ $comment->parent->created_at->format('M d, Y H:i') }}</small>
                            <div class="mt-2 p-2 bg-light rounded">
                                {{ $comment->parent->content }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Initialize iCheck plugin
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
});
</script>
@endpush
