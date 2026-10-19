@extends('layouts.app')

@section('title', 'Permission Management')

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title mb-0">Tambah Permission</h3></div>
        <form method="POST" action="{{ route('security.permissions.store') }}">
            @csrf
            <div class="card-body">
                <x-alert />
                @include('security.permissions._form')
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('security.permissions.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
@endsection
