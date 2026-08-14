@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Edit Role

        </h3>

    </div>

    <form method="POST"
          action="{{ route('security.roles.update', $role->RoleID) }}">

        @csrf

        @method('PUT')

        <div class="card-body">

            @include('security.roles._form', ['mode' => 'edit'])

            @include('security.roles._permissions')

        </div>

        <div class="card-footer">

            <a href="{{ route('security.roles.index') }}"
               class="btn btn-secondary">

                Back

            </a>

            <button
                type="submit"
                class="btn btn-primary">

                Update

            </button>

        </div>

    </form>

</div>

@endsection