@extends('layouts.app')
@section('title', 'City')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">City</h5>@canAdd('master.city.index')<a href="{{ route('master.city.create') }}"
                class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>@endcanAdd
        </div>
        <div class="card-body"><x-alert />
            <form method="GET" action="{{ route('master.city.index') }}" class="row g-2 mb-3">
                <div class="col-md-6"><input type="text" name="search" class="form-control"
                        placeholder="Cari ID atau nama city..." value="{{ request('search') }}"></div>
                <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
                @if (request('search'))
                    <div class="col-auto"><a href="{{ route('master.city.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                @endif
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>City ID</th>
                            <th>City</th>
                            <th>Province</th>
                            <th width="120">Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cities as $row)
                            <tr>
                                <td>{{ $cities->firstItem() + $loop->index }}</td>
                                <td>{{ $row->CityID }}</td>
                                <td>{{ $row->City }}</td>
                                <td>{{ $row->province?->Province ?? '-' }}</td>
                                <td>
                                    @if ($row->IsActive)
                                    <span class="badge bg-success">Active</span>@else<span
                                            class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>@canEdit('master.city.index')<a href="{{ route('master.city.edit', $row->CityID) }}"
                                        class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                                    @canDelete('master.city.index')<form
                                        action="{{ route('master.city.destroy', $row->CityID) }}" method="POST"
                                        class="d-inline">@csrf @method('DELETE')<button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menonaktifkan data ini?')"><i
                                                class="bi bi-trash"></i></button></form>@endcanDelete</td>
                        </tr>@empty<tr>
                                <td colspan="7" class="text-center">Tidak ada data City.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>{{ $cities->links() }}
        </div>
    </div>
@endsection
