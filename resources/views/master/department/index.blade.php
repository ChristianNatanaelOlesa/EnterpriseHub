@extends('layouts.app')

@section('title', 'Department')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Department
            </h5>

            @canAdd('master.department.index')

            <a href="{{ route('master.department.create') }}" class="btn btn-primary">
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

            <form method="GET" action="{{ route('master.department.index') }}" class="row g-2 mb-3">

                <div class="col-md-6">

                    <input type="text" name="search" class="form-control"
                        placeholder="Cari kode atau nama department..." value="{{ request('search') }}">

                </div>

                <div class="col-auto">

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                </div>

                @if (request('search'))
                    <div class="col-auto">

                        <a href="{{ route('master.department.index') }}" class="btn btn-secondary">
                            Reset
                        </a>

                    </div>
                @endif

            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="180">
                                Company
                            </th>

                            <th width="180">
                                Directorate
                            </th>

                            <th width="180">
                                Division
                            </th>

                            <th width="150">
                                Kode
                            </th>

                            <th>
                                Nama
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

                        @forelse ($departments as $department)
                            <tr>

                                <td>
                                    {{ $department->division?->directorate?->company?->CompanyName ?? '-' }}
                                </td>

                                <td>
                                    {{ $department->division?->directorate?->DirectorateName ?? '-' }}
                                </td>

                                <td>
                                    {{ $department->division?->DivisionName ?? '-' }}
                                </td>

                                <td>
                                    {{ $department->DepartmentCode }}
                                </td>

                                <td>
                                    {{ $department->DepartmentName }}
                                </td>

                                <td>

                                    @if ($department->IsActive)
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

                                    @canEdit('master.department.index')

                                    <a href="{{ route('master.department.edit', $department->DepartmentID) }}"
                                        class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i>

                                        Edit

                                    </a>

                                    @endcanEdit

                                    @canDelete('master.department.index')

                                    <form method="POST"
                                        action="{{ route('master.department.destroy', $department->DepartmentID) }}"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Nonaktifkan Department ini?')">

                                            <i class="bi bi-trash"></i>

                                            Delete

                                        </button>

                                    </form>

                                    @endcanDelete

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center">
                                    Tidak ada data Department.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $departments->links() }}

        </div>

    </div>

@endsection
