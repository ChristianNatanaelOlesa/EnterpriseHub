@extends('layouts.app')

@section('title', 'Menu Management - Add Menu')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Menu Management - Add Menu
            </h3>

        </div>

        <form method="POST" action="{{ route('security.menus.store') }}">

            @csrf

            <div class="card-body">

                @include('security.menus._form')
                <p class="text-muted small mb-0">Set available permissions after saving the menu. A mapping does not grant access to any role.</p>

            </div>

            <div class="card-footer">

                <a href="{{ route('security.menus.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save
                </button>

            </div>

        </form>

    </div>

@endsection
