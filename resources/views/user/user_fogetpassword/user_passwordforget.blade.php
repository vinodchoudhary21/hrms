<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #6c63ff;
        }

        .btn-primary {
            background-color: #6c63ff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5a54e8;
        }

        .logo {
            width: 70px;
        }

        .back-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <img src="{{ url('/') }}/public/web/assets/images/logo.png" alt="Logo" class="logo mb-2">
                    <h4 class="fw-bold text-primary">Forgot Your Password?</h4>
                </div>

                {{-- Alert Messages --}}
                @if ($message = Session::get('opt_modal'))
                    <div class="alert alert-success">{{ $message }}</div>
                @endif
                @if ($message = Session::get('error_otp_check'))
                    <div class="alert alert-danger">{{ $message }}</div>
                @endif

                {{-- Step 1: New Password --}}
                @if (session()->has('forget_otp'))
                    <form action="{{ route('ADMIN.New.passs') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Enter new password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>

                    {{-- Step 2: OTP --}}
                @elseif(session()->has('verify_email'))
                    <form action="{{ route('ADMIN.Check.otps') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Enter OTP</label>
                            <input type="number" name="otp" class="form-control" placeholder="Enter OTP">
                            @error('otp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                    </form>

                    {{-- Step 3: Email --}}
                @else
                    <form action="{{ route('ADMIN.Check.Verifys') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Registered Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send OTP</button>
                    </form>
                @endif

                <div class="back-link">
                    <a href="{{ route('login.user') }}" class="text-decoration-none">← Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
