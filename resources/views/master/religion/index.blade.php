@extends('layouts.app')

@section('title', 'Religion')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                Religion
            </h5>

            @canAdd('master.religion.index')
                <a href="{{ route('master.religion.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah
                </a>
            @endcanAdd

        </div>

        <div class="card-body">

            <x-alert />

            <form method="GET"
                  action="{{ route('master.religion.index') }}"
                  class="row g-2 mb-3">

                <div class="col-md-6">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari ID atau nama religion..."
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

                        <a href="{{ route('master.religion.index') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                @endif

            </form>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                Religion ID
                            </th>

                            <th>
                                Religion
                            </th>

                            <th width="120">
                                Status
                            </th>

                            <th width="150">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($religions as $religion)

                            <tr>

                                <td>
                                    {{ $religions->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    {{ $religion->ReligionID }}
                                </td>

                                <td>
                                    {{ $religion->Religion }}
                                </td>

                                <td>

                                    @if ($religion->IsActive)

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

                                    @canEdit('master.religion.index')

                                        <a href="{{ route('master.religion.edit', $religion->ReligionID) }}"
                                           class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                    @endcanEdit

                                    @canDelete('master.religion.index')

                                        <form
                                            action="{{ route('master.religion.destroy', $religion->ReligionID) }}"
                                            method="POST"
                                            class="d-inline"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus religion ini?')"
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
                                    Tidak ada data Religion.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{ $religions->links() }}

        </div>

    </div>

@endsection