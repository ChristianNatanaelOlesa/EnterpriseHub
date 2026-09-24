@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="eh-auth-card">
    <div class="eh-auth-card-body">
        <h2 class="eh-auth-title">Forgot your password?</h2>
        <p class="eh-auth-subtitle">Enter your email address and we'll send you a password reset link.</p>

        @if (session('status'))
            <div class="alert alert-success eh-auth-alert" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger eh-auth-alert" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input
                    type="email"
                    name="Email"
                    class="form-control"
                    placeholder="Email"
                    value="{{ old('Email') }}"
                    autocomplete="email"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="btn btn-primary w-100 eh-auth-btn">
                <i class="bi bi-envelope-arrow-up me-1"></i>
                Request new password
            </button>
        </form>

        <div class="eh-auth-links">
            <a href="{{ route('login') }}">Login</a>
            <span class="text-secondary mx-1">&middot;</span>
            <a href="{{ route('register') }}">Register a new membership</a>
        </div>
    </div>
</div>
@endsection
