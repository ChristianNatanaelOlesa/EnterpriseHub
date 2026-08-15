@extends('layouts.app')

@section('title', 'Directorate')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Directorate
            </h5>

            @canAdd('master.directorate.index')

            <a href="{{ route('master.directorate.create') }}" class="btn btn-primary">
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

            <form method="GET" action="{{ route('master.directorate.index') }}" class="row g-2 mb-3">

                <div class="col-md-6">

                    <input type="text" name="search" class="form-control"
                        placeholder="Cari kode atau nama directorate..." value="{{ request('search') }}">

                </div>

                <div class="col-auto">

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                </div>

                @if (request('search'))
                    <div class="col-auto">

                        <a href="{{ route('master.directorate.index') }}" class="btn btn-secondary">
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

                        @forelse ($directorates as $directorate)
                            <tr>

                                <td>
                                    {{ $directorate->company?->CompanyName ?? '-' }}
                                </td>

                                <td>
                                    {{ $directorate->DirectorateCode }}
                                </td>

                                <td>
                                    {{ $directorate->DirectorateName }}
                                </td>

                                <td>

                                    @if ($directorate->IsActive)
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

                                    @canEdit('master.directorate.index')

                                    <a href="{{ route('master.directorate.edit', $directorate->DirectorateID) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>

                                    @endcanEdit

                                    @canDelete('master.directorate.index')

                                    <form method="POST"
                                        action="{{ route('master.directorate.destroy', $directorate->DirectorateID) }}"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Nonaktifkan Directorate ini?')">
                                            <i class="bi bi-trash"></i>
                                            Delete
                                        </button>

                                    </form>

                                    @endcanDelete

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">
                                    Tidak ada data Directorate.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $directorates->links() }}

        </div>

    </div>

@endsection
