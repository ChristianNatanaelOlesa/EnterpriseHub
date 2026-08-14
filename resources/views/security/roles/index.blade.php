@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title">

            Role Management

        </h3>

        <a href="{{ route('security.roles.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg"></i>

            Add Role

        </a>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>

                    <tr>

                        <th width="60">No</th>

                        <th>Code</th>

                        <th>Name</th>

                        <th>Description</th>

                        <th width="120">Status</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($roles as $role)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $role->Code }}</td>

                            <td>{{ $role->Name }}</td>

                            <td>{{ $role->Description }}</td>

                            <td>

                                @if($role->IsActive)

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

                                <a href="{{ route('security.roles.edit', $role->RoleID) }}" class="btn btn-sm btn-warning">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form action="{{ route('security.roles.destroy', $role->RoleID) }}" method="POST" class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus role ini?')">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                                {{-- <form action="{{ route('security.roles.toggle-status', $role->RoleID) }}" method="POST" class="d-inline">

                                    @csrf

                                    <button type="submit" class="btn btn-sm {{ $role->IsActive ? 'btn-secondary' : 'btn-success' }}">

                                        <i class="bi {{ $role->IsActive ? 'bi-pause-fill' : 'bi-play-fill' }}"></i>

                                    </button>

                                </form> --}}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No Data

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">

                {{ $roles->links() }}

            </div>

        </div>

    </div>

</div>

@endsection