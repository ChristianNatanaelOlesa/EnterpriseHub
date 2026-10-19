@extends('layouts.app')

@section('title', 'Permission Management')

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title mb-0">Ubah Permission</h3></div>
        <form method="POST" action="{{ route('security.permissions.update', $permission->PermissionID) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <x-alert />
                @include('security.permissions._form', ['permission' => $permission])
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('security.permissions.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
