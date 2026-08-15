@extends('layouts.app')

@section('title', 'Company')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Company
            </h5>

            @canAdd('master.company.index')

            <a href="{{ route('master.company.create') }}" class="btn btn-primary">
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

            <form method="GET" action="{{ route('master.company.index') }}" class="row g-2 mb-3">

                <div class="col-md-6">

                    <input type="text" name="search" class="form-control" placeholder="Cari kode atau nama company..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-auto">

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                </div>

                @if (request('search'))
                    <div class="col-auto">

                        <a href="{{ route('master.company.index') }}" class="btn btn-secondary">
                            Reset
                        </a>

                    </div>
                @endif

            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="150">
                                Kode
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                Email
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

                        @forelse ($companies as $company)
                            <tr>

                                <td>
                                    {{ $company->CompanyCode }}
                                </td>

                                <td>
                                    {{ $company->CompanyName }}
                                </td>

                                <td>
                                    {{ $company->Email ?? '-' }}
                                </td>

                                <td>

                                    @if ($company->IsActive)
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

                                    @canEdit('master.company.index')

                                    <a href="{{ route('master.company.edit', $company->CompanyID) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @endcanEdit

                                    @canDelete('master.company.index')

                                    <form action="{{ route('master.company.destroy', $company->CompanyID) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus company ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                    @endcanDelete

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">
                                    Tidak ada data Company.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $companies->links() }}

        </div>

    </div>

@endsection
