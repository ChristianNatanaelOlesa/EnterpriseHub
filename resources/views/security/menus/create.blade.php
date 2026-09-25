@extends('layouts.app')

@section('title', 'Add Menu')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Add Menu
            </h3>

        </div>

        <form method="POST" action="{{ route('security.menus.store') }}">

            @csrf

            <div class="card-body">

                @include('security.menus._form')

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
