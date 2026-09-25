@extends('layouts.app')

@section('title', 'Create Role')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Create Role
            </h3>

        </div>

        <form method="POST" action="{{ route('security.roles.store') }}">

            @csrf

            <div class="card-body">

                @include('security.roles._form', [
                    'mode' => 'create',
                ])

                @include('security.roles._permissions', [
                    'menus' => $menus,
                    'permissions' => $permissions,
                ])

            </div>

            <div class="card-footer">

                <a href="{{ route('security.roles.index') }}" class="btn btn-secondary">

                    Back

                </a>

                <button type="submit" class="btn btn-primary">

                    Save

                </button>

            </div>

        </form>

    </div>

@endsection
