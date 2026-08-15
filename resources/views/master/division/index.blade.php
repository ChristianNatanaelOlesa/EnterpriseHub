@extends('layouts.app')

@section('title', 'Division')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Division
            </h5>

            @canAdd('master.division.index')

            <a href="{{ route('master.division.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah
            </a>

            @endcanAdd

        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('master.division.index') }}" class="row g-2 mb-3">

                <div class="col-md-6">

                    <input type="text" name="search" class="form-control" placeholder="Cari kode atau nama division..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-auto">

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                </div>

                @if (request('search'))
                    <div class="col-auto">

                        <a href="{{ route('master.division.index') }}" class="btn btn-secondary">
                            Reset
                        </a>

                    </div>
                @endif

            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Directorate</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($divisions as $division)
                            <tr>

                                <td>
                                    {{ $division->directorate?->company?->CompanyName ?? '-' }}
                                </td>

                                <td>
                                    {{ $division->directorate?->DirectorateName ?? '-' }}
                                </td>

                                <td>
                                    {{ $division->DivisionCode }}
                                </td>

                                <td>
                                    {{ $division->DivisionName }}
                                </td>

                                <td>

                                    @if ($division->IsActive)
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    @canEdit('master.division.index')

                                    <a href="{{ route('master.division.edit', $division->DivisionID) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>

                                    @endcanEdit

                                    @canDelete('master.division.index')

                                    <form method="POST"
                                        action="{{ route('master.division.destroy', $division->DivisionID) }}"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Nonaktifkan Division ini?')">
                                            <i class="bi bi-trash"></i>
                                            Delete
                                        </button>

                                    </form>

                                    @endcanDelete

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">
                                    Tidak ada data Division.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $divisions->links() }}

        </div>

    </div>

@endsection
