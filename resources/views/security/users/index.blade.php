@extends('layouts.app')

@section('title', 'User Access')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User Access</h5>
            @canAdd('security.users.index')
            <a href="{{ route('security.users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
            @endcanAdd
        </div>

        <div class="card-body">
            <x-alert />
            <form method="GET" action="{{ route('security.users.index') }}" class="row g-2 mb-3">
                <div class="col-md-6"><input type="text" name="search" class="form-control"
                        placeholder="Cari username, nama, email, atau role..." value="{{ request('search') }}"></div>
                <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
                @if (request('search'))
                    <div class="col-auto"><a href="{{ route('security.users.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Job Title</th>
                            <th width="120">Join Date</th>
                            <th width="100">Status</th>
                            <th width="220">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td>{{ $user->Username }}</td>
                                <td>{{ $user->FullName }}</td>
                                <td>{{ $user->Email }}</td>
                                <td>{{ $user->JobTitleName ?? '-' }}</td>
                                <td>{{ $user->JoinDate ? \Carbon\Carbon::parse($user->JoinDate)->format('d M Y') : '-' }}</td>
                                <td>
                                    @if ($user->IsActive)
                                    <span class="badge bg-success">Active</span>@else<span
                                            class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @canEdit('security.users.index')
                                    <a href="{{ route('security.users.edit', $user->UserID) }}"
                                        class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <button type="button" class="btn btn-sm btn-info" title="Lihat Role"
                                        onclick="showRolesModal({{ $user->UserID }}, '{{ $user->Username }}')"><i
                                            class="bi bi-badge-3d"></i></button>
                                    <form action="{{ route('security.users.reset-password', $user->UserID) }}"
                                        method="POST" class="d-inline">@csrf<button type="submit"
                                        class="btn btn-sm btn-info" title="Reset Password"
                                        onclick="return confirm('Reset password user ini menjadi password default?')"><i
                                            class="bi bi-key"></i></button></form>
                                    <form action="{{ route('security.users.toggle-status', $user->UserID) }}"
                                        method="POST" class="d-inline">@csrf<button type="submit"
                                        class="btn btn-sm {{ $user->IsActive ? 'btn-secondary' : 'btn-success' }}"
                                        title="{{ $user->IsActive ? 'Deactivate' : 'Activate' }}"><i
                                            class="bi {{ $user->IsActive ? 'bi-pause-fill' : 'bi-play-fill' }}"></i></button>
                                    </form>
                                    @endcanEdit
                                    @canDelete('security.users.index')
                                    <form action="{{ route('security.users.destroy', $user->UserID) }}" method="POST"
                                        class="d-inline">@csrf @method('DELETE')<button type="submit"
                                        class="btn btn-sm btn-danger" title="Delete"
                                        onclick="return confirm('Yakin ingin menghapus user ini?')"><i
                                            class="bi bi-trash"></i></button></form>
                                    @endcanDelete
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data User.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Lihat Role -->
    <div class="modal fade" id="rolesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rolesModalLabel">Role User: <span id="modalUserName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalRolesBody">
                    <p class="text-muted">Memuat data role...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function showRolesModal(userId, userName) {
        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('modalRolesBody').innerHTML = '<p class="text-muted">Memuat data role...</p>';

        var modal = new bootstrap.Modal(document.getElementById('rolesModal'));
        modal.show();

        fetch('{{ route('security.users.roles', 'PLACEHOLDER') }}'.replace('PLACEHOLDER', userId))
            .then(response => response.json())
            .then(data => {
                var body = document.getElementById('modalRolesBody');
                if (!data.roles || data.roles.length === 0) {
                    body.innerHTML = '<p class="text-muted">User ini tidak memiliki role.</p>';
                    return;
                }
                var html = '<table class="table table-sm table-borderless">';
                html += '<thead><tr><th>Role ID</th><th>Role</th><th>Status</th></tr></thead><tbody>';
                data.roles.forEach(function(role) {
                    html += '<tr>';
                    html += '<td><code>' + role.RoleID + '</code></td>';
                    html += '<td>' + role.Role + '</td>';
                    html += '<td>' + (role.pivot_is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>') + '</td>';
                    html += '</tr>';
                });
                html += '</tbody></table>';
                body.innerHTML = html;
            })
            .catch(() => {
                document.getElementById('modalRolesBody').innerHTML = '<p class="text-danger">Gagal memuat data role.</p>';
            });
    }
</script>
@endpush
