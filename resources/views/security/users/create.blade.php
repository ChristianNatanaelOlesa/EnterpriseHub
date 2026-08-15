@extends('layouts.app')

@section('title', 'Create User')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Create User
            </h3>

        </div>

        <form method="POST" action="{{ route('security.users.store') }}">

            @csrf

            <div class="card-body">

                @include('security.users._form', [
                    'mode' => 'create',
                    'roles' => $roles,
                    'userRoleIds' => [],
                ])

            </div>

            <div class="card-footer">

                <a href="{{ route('security.users.index') }}" class="btn btn-secondary">
                    Back
                </a>

                <button type="submit" class="btn btn-primary">
                    Save
                </button>

            </div>

        </form>

    </div>

@endsection
