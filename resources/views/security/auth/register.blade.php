@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="eh-auth-card">
    <div class="eh-auth-card-body">
        <h2 class="eh-auth-title">Register a new membership</h2>
        <p class="eh-auth-subtitle">Create an account to access EnterpriseHub.</p>

        @if ($errors->any())
            <div class="alert alert-danger eh-auth-alert" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                <input type="text" name="FullName" class="form-control" placeholder="Full Name" value="{{ old('FullName') }}" required autofocus>
            </div>

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="Username" class="form-control" placeholder="Username" value="{{ old('Username') }}" required autocomplete="username">
            </div>

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="Email" class="form-control" placeholder="Email" value="{{ old('Email') }}" required autocomplete="email">
            </div>

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="Password" class="form-control" placeholder="Password" required autocomplete="new-password">
            </div>

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="Password_confirmation" class="form-control" placeholder="Confirm Password" required autocomplete="new-password">
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="terms" value="1" id="terms" required>
                <label class="form-check-label small" for="terms">
                    I agree to the <a href="#" class="text-decoration-none">terms</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100 eh-auth-btn">
                <i class="bi bi-person-plus me-1"></i>
                Sign Up
            </button>
        </form>

        <div class="eh-auth-links">
            Already have a membership?
            <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>
@endsection
