@extends('layouts.app')

@section('title', 'Forbidden')

@section('content')

    <div class="card">

        <div class="card-body text-center py-5">

            <div class="mb-4">

                <i class="bi bi-shield-lock text-danger" style="font-size: 64px;"></i>

            </div>

            <h2 class="mb-2">
                Access Denied
            </h2>

            <p class="text-muted mb-4">
                You do not have permission to access this resource.
            </p>

            <a href="{{ route('dashboard') }}" class="btn btn-primary">

                <i class="bi bi-house"></i>

                Back to Dashboard

            </a>

        </div>

    </div>

@endsection
