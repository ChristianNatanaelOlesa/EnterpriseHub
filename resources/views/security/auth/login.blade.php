@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="eh-auth-card">
        <div class="eh-auth-card-body">
            <h2 class="eh-auth-title">Sign in to your account</h2>
            <p class="eh-auth-subtitle">Enter your credentials to start your session.</p>

            @if ($errors->any())
                <div class="alert alert-danger eh-auth-alert" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success eh-auth-alert" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="input-group eh-auth-input mb-3">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control @error('Username') is-invalid @enderror" name="Username"
                        placeholder="Username" value="{{ old('Username') }}" autocomplete="username" required autofocus>
                </div>

                <div class="input-group eh-auth-input mb-3">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control @error('Password') is-invalid @enderror" name="Password"
                        placeholder="Password" autocomplete="current-password" required>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember">
                        <label class="form-check-label small" for="remember">Remember Me</label>
                    </div>

                    <a href="{{ route('password.request') }}" class="small text-decoration-none">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary w-100 eh-auth-btn">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Sign In
                </button>
            </form>

            <div class="eh-demo-box">
                <div class="eh-demo-box-title">Portfolio Demo Account</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered eh-demo-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>admin</code></td>
                                <td><code>admin123</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="small text-secondary mt-2">
                    Use this account to explore the portfolio demo.
                </div>
            </div>

            <div class="eh-auth-links">
                Don't have an account?
                <a href="{{ route('register') }}">Register a new membership</a>
            </div>
        </div>
    </div>
@endsection
