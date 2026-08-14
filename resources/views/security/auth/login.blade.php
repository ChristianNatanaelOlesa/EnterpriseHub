@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<div class="card card-outline card-primary">

    <div class="card-header text-center">

        <a href="#" class="h3">
            <b>Enterprise</b>Hub
        </a>

    </div>

    <div class="card-body">

        <p class="login-box-msg">
            Sign in to start your session
        </p>

        <form method="POST" action="{{ route('login.store') }}">

            @csrf

            <div class="input-group mb-3">

                <input
                    type="text"
                    class="form-control @error('Username') is-invalid @enderror"
                    name="Username"
                    placeholder="Username"
                    value="{{ old('Username') }}"
                    required
                >

                <div class="input-group-text">
                    <span class="bi bi-person"></span>
                </div>

            </div>

            @error('Username')
                <div class="text-danger mb-3">
                    {{ $message }}
                </div>
            @enderror

            <div class="input-group mb-3">

                <input
                    type="password"
                    class="form-control"
                    name="Password"
                    placeholder="Password"
                    required
                >

                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
                </div>

            </div>

            <div class="row">

                <div class="col-12">

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Sign In
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection