@extends('template.admin')

@section('title', $title)

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" 
                             src="{{ $user->getAvatarUrl() }}" 
                             alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ ucfirst($user->role) }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Member Since</b> <a class="float-right">{{ $user->created_at->format('M d, Y') }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <form class="form-horizontal" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                  id="bio" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="avatar" class="col-sm-2 col-form-label">Avatar</label>
                                    <div class="col-sm-10">
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
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="password">
                            <form class="form-horizontal" action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                               id="new_password" name="new_password">
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="new_password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" 
                                               id="new_password_confirmation" name="new_password_confirmation">
                                        @error('new_password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
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
