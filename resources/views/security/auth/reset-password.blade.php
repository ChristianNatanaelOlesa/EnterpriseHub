@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="eh-auth-card">
    <div class="eh-auth-card-body">
        <h2 class="eh-auth-title">Reset your password</h2>
        <p class="eh-auth-subtitle">Choose a new password for your EnterpriseHub account.</p>

        @if ($errors->any())
            <div class="alert alert-danger eh-auth-alert" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="Email" class="form-control" placeholder="Email" value="{{ old('Email', $email) }}" required autocomplete="email">
            </div>

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="Password" class="form-control" placeholder="New Password" required autocomplete="new-password">
            </div>

            <div class="input-group eh-auth-input mb-3">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="Password_confirmation" class="form-control" placeholder="Confirm Password" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary w-100 eh-auth-btn">
                <i class="bi bi-key me-1"></i>
                Reset Password
            </button>
        </form>

        <div class="eh-auth-links">
            <a href="{{ route('login') }}">Back to login</a>
        </div>
    </div>
</div>
@endsection
