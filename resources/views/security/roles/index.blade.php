@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Role Management</h5>
        @canAdd('security.roles.index')
            <a href="{{ route('security.roles.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        @endcanAdd
    </div>

    <div class="card-body">
        <x-alert />
        <form method="GET" action="{{ route('security.roles.index') }}" class="row g-2 mb-3">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari kode, nama, atau description role..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
            @if(request('search'))<div class="col-auto"><a href="{{ route('security.roles.index') }}" class="btn btn-secondary">Reset</a></div>@endif
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead><tr><th width="60">#</th><th>Code</th><th>Name</th><th>Description</th><th width="120">Status</th><th width="150">Action</th></tr></thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $roles->firstItem() + $loop->index }}</td><td>{{ $role->Code }}</td><td>{{ $role->Name }}</td><td>{{ $role->Description ?? '-' }}</td>
                            <td>@if($role->IsActive)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif</td>
                            <td class="text-nowrap">
                                @canEdit('security.roles.index')<a href="{{ route('security.roles.edit', $role->RoleID) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                                @canDelete('security.roles.index')<form action="{{ route('security.roles.destroy', $role->RoleID) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus role ini?')"><i class="bi bi-trash"></i></button></form>@endcanDelete
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Tidak ada data Role.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $roles->links() }}
    </div>
</div>
@endsection
