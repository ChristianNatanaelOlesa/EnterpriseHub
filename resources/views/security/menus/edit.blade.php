@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Edit Menu
        </h3>

    </div>

    <form
        method="POST"
        action="{{ route('security.menus.update', $menu->MenuID) }}"
    >

        @csrf
        @method('PUT')

        <div class="card-body">

            @include('security.menus._form')

        </div>

        <div class="card-footer">

            <a
                href="{{ route('security.menus.index') }}"
                class="btn btn-secondary"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Update
            </button>

        </div>

    </form>

</div>

@endsection