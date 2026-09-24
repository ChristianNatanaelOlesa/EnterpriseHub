@extends('layouts.app')

@section('title', 'Menus')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Menu Management</h5>
        @canAdd('security.menus.index')
            <a href="{{ route('security.menus.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        @endcanAdd
    </div>

    <div class="card-body">
        <x-alert />
        <form method="GET" action="{{ route('security.menus.index') }}" class="row g-2 mb-3">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari code, nama, parent, atau route menu..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
            @if(request('search'))<div class="col-auto"><a href="{{ route('security.menus.index') }}" class="btn btn-secondary">Reset</a></div>@endif
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead><tr><th width="60">#</th><th>Code</th><th>Name</th><th>Parent</th><th>Route</th><th>Sort</th><th width="120">Status</th><th width="150">Action</th></tr></thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>{{ $menus->firstItem() + $loop->index }}</td>
                            <td>{{ $menu->Code }}</td>
                            <td>@if($menu->ParentID)&nbsp;&nbsp;&nbsp;↳ @endif{{ $menu->Name }}</td>
                            <td>{{ $menu->parent?->Name ?? '-' }}</td>
                            <td>{{ $menu->Route ?? '-' }}</td>
                            <td>{{ $menu->SortOrder }}</td>
                            <td>@if($menu->IsActive)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif</td>
                            <td class="text-nowrap">
                                @canEdit('security.menus.index')<a href="{{ route('security.menus.edit', $menu->MenuID) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                                @canDelete('security.menus.index')<form action="{{ route('security.menus.destroy', $menu->MenuID) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus menu ini?')"><i class="bi bi-trash"></i></button></form>@endcanDelete
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Tidak ada data Menu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $menus->links() }}
    </div>
</div>
@endsection
