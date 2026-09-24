@extends('layouts.app')

@section('title', 'Email Group')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Email Group
            </h5>

            @canAdd('master.email-group.index')
                <a href="{{ route('master.email-group.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah
                </a>
            @endcanAdd

        </div>

        <div class="card-body">

            <x-alert />

            <form method="GET"
                  action="{{ route('master.email-group.index') }}"
                  class="row g-2 mb-3">

                <div class="col-md-6">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari ID, email, atau description..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </div>

                @if (request('search'))
                    <div class="col-auto">
                        <a href="{{ route('master.email-group.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                @endif

            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th width="120">Email Group ID</th>
                            <th>Division</th>
                            <th>Email</th>
                            <th>Description</th>
                            <th width="110">Is Group</th>
                            <th width="110">Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($emailGroups as $emailGroup)
                            <tr>
                                <td>{{ $emailGroups->firstItem() + $loop->index }}</td>
                                <td>{{ $emailGroup->EmailGroupID }}</td>
                                <td>{{ $emailGroup->division?->DivisionName ?? '-' }}</td>
                                <td>{{ $emailGroup->Email }}</td>
                                <td>{{ $emailGroup->Description }}</td>
                                <td>
                                    @if ($emailGroup->IsGroup)
                                        <span class="badge bg-info text-dark">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($emailGroup->IsActive)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @canEdit('master.email-group.index')
                                        <a href="{{ route('master.email-group.edit', $emailGroup->EmailGroupID) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endcanEdit

                                    @canDelete('master.email-group.index')
                                        <form action="{{ route('master.email-group.destroy', $emailGroup->EmailGroupID) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus Email Group ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcanDelete
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Tidak ada data Email Group.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $emailGroups->links() }}

        </div>

    </div>

@endsection
