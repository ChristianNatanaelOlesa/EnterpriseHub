@extends('layouts.app')

@section('title', 'Country')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Country
            </h5>

            @canAdd('master.country.index')
                <a href="{{ route('master.country.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah
                </a>
            @endcanAdd

        </div>

        <div class="card-body">

            <x-alert />

            <form
                method="GET"
                action="{{ route('master.country.index') }}"
                class="row g-2 mb-3"
            >

                <div class="col-md-6">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari ID atau nama country..."
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

                        <a
                            href="{{ route('master.country.index') }}"
                            class="btn btn-secondary"
                        >
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
                            <th>Country ID</th>
                            <th>Country</th>
                            <th width="120">Status</th>
                            <th width="150">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($countries as $country)

                            <tr>

                                <td>
                                    {{ $countries->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $country->CountryID }}
                                </td>

                                <td>
                                    {{ $country->Country }}
                                </td>

                                <td>

                                    @if ($country->IsActive)

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

                                    @canEdit('master.country.index')

                                        <a
                                            href="{{ route('master.country.edit', $country->CountryID) }}"
                                            class="btn btn-sm btn-warning"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                    @endcanEdit

                                    @canDelete('master.country.index')

                                        <form
                                            action="{{ route('master.country.destroy', $country->CountryID) }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menonaktifkan country ini?')"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    @endcanDelete

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">
                                    Tidak ada data Country.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $countries->links() }}

        </div>

    </div>

@endsection