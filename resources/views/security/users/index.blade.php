@extends('layouts.app')

@section('title', 'Users')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h3 class="card-title">
                User Management
            </h3>

            <a href="{{ route('security.users.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-lg"></i>

                Add User

            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                Username
                            </th>

                            <th>
                                Full Name
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Roles
                            </th>

                            <th width="120">
                                Status
                            </th>

                            <th width="180">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $user->Username }}
                                </td>

                                <td>
                                    {{ $user->FullName }}
                                </td>

                                <td>
                                    {{ $user->Email }}
                                </td>

                                <td>

                                    @forelse($user->roles as $role)
                                        <span class="badge text-bg-primary me-1">

                                            {{ $role->Name }}

                                        </span>

                                    @empty

                                        <span class="text-muted">
                                            No Role
                                        </span>
                                    @endforelse

                                </td>

                                <td>

                                    @if ($user->IsActive)
                                        <span class="badge text-bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge text-bg-danger">
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('security.users.edit', $user->UserID) }}"
                                        class="btn btn-sm btn-warning" title="Edit">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form action="{{ route('security.users.reset-password', $user->UserID) }}"
                                        method="POST" class="d-inline">

                                        @csrf

                                        <button type="submit" class="btn btn-sm btn-info" title="Reset Password"
                                            onclick="return confirm('Reset password user ini menjadi password default?')">

                                            <i class="bi bi-key"></i>

                                        </button>

                                    </form>

                                    <form action="{{ route('security.users.destroy', $user->UserID) }}" method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                    <form action="{{ route('security.users.toggle-status', $user->UserID) }}" method="POST"
                                        class="d-inline">

                                        @csrf

                                        <button type="submit"
                                            class="btn btn-sm {{ $user->IsActive ? 'btn-secondary' : 'btn-success' }}"
                                            title="{{ $user->IsActive ? 'Deactivate' : 'Activate' }}">

                                            <i class="bi {{ $user->IsActive ? 'bi-pause-fill' : 'bi-play-fill' }}"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center">

                                    No Data

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="mt-3">

                    {{ $users->links() }}

                </div>

            </div>

        </div>

    </div>

@endsection
