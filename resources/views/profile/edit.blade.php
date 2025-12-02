@extends('template.app')

@section('title', $title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img class="rounded-circle profile-avatar" 
                             src="{{ $user->getAvatarUrl() }}" 
                             alt="User profile picture" width="150">
                    </div>

                    <h3 class="text-center mt-3">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ ucfirst($user->role) }}</p>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Email</strong>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Member Since</strong>
                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#profile" data-toggle="tab">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#password" data-toggle="tab">Password</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bio" class="col-sm-3 col-form-label">Bio</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                  id="bio" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="avatar" class="col-sm-3 col-form-label">Avatar</label>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" 
                                                   id="avatar" name="avatar">
                                            <label class="custom-file-label" for="avatar">Choose file...</label>
                                            @error('avatar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Allowed file types: jpeg, png, jpg, gif. Max size: 2MB.</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="password">
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="current_password" class="col-sm-3 col-form-label">Current Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                               id="new_password" name="new_password">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password_confirmation" class="col-sm-3 col-form-label">Confirm Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                               id="new_password_confirmation" name="new_password_confirmation">
                                        @error('new_password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
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
    // Custom file input label
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $(this).next('.custom-file-label').html(fileName);
    });
</script>
@endpush
