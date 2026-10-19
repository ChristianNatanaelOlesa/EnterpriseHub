@extends('layouts.app')

@section('title', 'User Access - Edit Account')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                User Access - Edit Account

            </h3>

        </div>

        <form method="POST" action="{{ route('security.users.update', $user->UserID) }}">

            @csrf

            @method('PUT')

            <div class="card-body">

                @include('security.users._form', [
                    'mode' => 'edit',
                    'roles' => $roles,
                    'userRoleIds' => $userRoleIds,
                ])

            </div>

            <div class="card-footer">

                <a href="{{ route('security.users.index') }}" class="btn btn-secondary">

                    Back

                </a>

                <button type="submit" class="btn btn-primary">

                    Update

                </button>

            </div>

        </form>

    </div>

@endsection
