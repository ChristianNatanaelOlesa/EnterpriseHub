@extends('layouts.app')

@section('title', 'Province')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Province
            </h5>

            @canAdd('master.province.index')
            <a href="{{ route('master.province.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah
            </a>
            @endcanAdd

        </div>

        <div class="card-body">

            <x-alert />

            <form method="GET" action="{{ route('master.province.index') }}" class="row g-2 mb-3">

                <div class="col-md-6">

                    <input type="text" name="search" class="form-control" placeholder="Cari ID atau nama province..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-auto">

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                </div>

                @if (request('search'))
                    <div class="col-auto">

                        <a href="{{ route('master.province.index') }}" class="btn btn-secondary">
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
                            <th>Province ID</th>
                            <th>Province</th>
                            <th>Country</th>
                            <th width="120">Status</th>
                            <th width="150">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($provinces as $province)
                            <tr>

                                <td>
                                    {{ $provinces->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $province->ProvinceID }}
                                </td>

                                <td>
                                    {{ $province->Province }}
                                </td>

                                <td>
                                    {{ $province->country?->Country ?? '-' }}
                                </td>

                                <td>

                                    @if ($province->IsActive)
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

                                    @canEdit('master.province.index')

                                    <a href="{{ route('master.province.edit', $province->ProvinceID) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @endcanEdit

                                    @canDelete('master.province.index')

                                    <form action="{{ route('master.province.destroy', $province->ProvinceID) }}"
                                        method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menonaktifkan province ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                    @endcanDelete

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">
                                    Tidak ada data Province.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $provinces->links() }}

        </div>

    </div>

@endsection
