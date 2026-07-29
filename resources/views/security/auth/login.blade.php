@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="row justify-content-center mt-5">

    <div class="col-md-4">

        <x-card>

            <x-slot:header>

                Login

            </x-slot:header>

            <form method="POST" action="{{ route('login.store') }}">

                @csrf

                <x-form.input
                    name="Username"
                    label="Username"
                    required
                />

                <x-form.input
                    name="Password"
                    label="Password"
                    type="password"
                    required
                />

                <x-button.save />

            </form>

        </x-card>

    </div>

</div>

@endsection