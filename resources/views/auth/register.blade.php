<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bacakuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #6366f1;
            --dark-bg: #ffffff;
            --darker-bg: #f8f9fa;
            --card-bg: #ffffff;
            --border-color: #dee2e6;
            --text-primary: #212529;
        }

        body {
            background: linear-gradient(135deg, var(--darker-bg) 0%, var(--dark-bg) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
        }

        .register-container {
            max-width: 400px;
            width: 100%;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4f46e5 100%);
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }

        .form-control {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 0.5rem;
            padding: 0.75rem;
        }

        .form-control:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 register-container">
                <div class="text-center mb-5">
                    <div class="loader-text">
                        <span class="icon-inline">
                            <img src="{{ asset('Image/buku.png') }}" alt="Logo Buku" width="46" height="46">
                        </span>
                        <span style="font-size: 2.5rem; font-weight: bold; color: #212529; letter-spacing: 2px;">Bacakuy</span>
                    </div>
                    <p class="text-muted">Create your account</p>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @php
                            $errors = $errors ?? null;
                        @endphp

                        @if ($errors && $errors->any())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control"
                                               id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-person-plus me-2"></i>Create Account
                            </button>
                        </form>
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Avatar preview
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
