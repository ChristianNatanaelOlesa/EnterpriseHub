@extends('layouts.app')

@section('title', 'Permission Management')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Permission Management</h5>
            @canAdd('security.permissions.index')
                <a href="{{ route('security.permissions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Permission
                </a>
            @endcanAdd
        </div>

        <div class="card-body">
            <x-alert />
            <form method="GET" action="{{ route('security.permissions.index') }}" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="search" name="search" class="form-control"
                        placeholder="Cari kode atau nama permission..." value="{{ request('search') }}">
                </div>
                <div class="col-auto"><button type="submit" class="btn btn-primary">Cari</button></div>
                @if (request('search'))
                    <div class="col-auto"><a href="{{ route('security.permissions.index') }}" class="btn btn-secondary">Reset</a></div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Menu tersedia</th>
                            <th width="120">Status</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                            <tr>
                                <td>{{ $permissions->firstItem() + $loop->index }}</td>
                                <td><code>{{ $permission->Name }}</code></td>
                                <td>{{ $permission->Name }}</td>
                                <td>{{ $permission->menu_count }}</td>
                                <td>
                                    @if ($permission->IsActive)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @canEdit('security.permissions.index')
                                        <a href="{{ route('security.permissions.edit', $permission->PermissionID) }}"
                                            class="btn btn-sm btn-warning" title="Ubah"><i class="bi bi-pencil"></i></a>
                                    @endcanEdit
                                    @if ($permission->IsActive)
                                        @canDelete('security.permissions.index')
                                            <form action="{{ route('security.permissions.destroy', $permission->PermissionID) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Nonaktifkan"
                                                    onclick="return confirm('Nonaktifkan permission ini? Assignment yang tersimpan akan tetap tercatat.')">
                                                    <i class="bi bi-pause-circle"></i>
                                                </button>
                                            </form>
                                        @endcanDelete
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada permission.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $permissions->links() }}
        </div>
    </div>
@endsection
