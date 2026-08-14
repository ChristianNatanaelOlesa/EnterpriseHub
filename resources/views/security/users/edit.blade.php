@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Edit User

        </h3>

    </div>

    <form method="POST" action="{{ route('security.users.update', $user->UserID) }}">

        @csrf

        @method('PUT')

        <div class="card-body">

           @include('security.users._form', [ 'mode' => 'edit'])

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