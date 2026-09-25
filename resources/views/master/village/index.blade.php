@extends('layouts.app')
@section('title', 'Village')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Village</h5>@canAdd('master.village.index')<a href="{{ route('master.village.create') }}"
                class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>@endcanAdd
        </div>
        <div class="card-body"><x-alert />
            <form method="GET" action="{{ route('master.village.index') }}" class="row g-2 mb-3">
                <div class="col-md-6"><input type="text" name="search" class="form-control"
                        placeholder="Cari ID atau nama village..." value="{{ request('search') }}"></div>
                <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
                @if (request('search'))
                    <div class="col-auto"><a href="{{ route('master.village.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                @endif
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Village ID</th>
                            <th>Village</th>
                            <th>District</th>
                            <th>Postal Code</th>
                            <th width="120">Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($villages as $row)
                            <tr>
                                <td>{{ $villages->firstItem() + $loop->index }}</td>
                                <td>{{ $row->VillageID }}</td>
                                <td>{{ $row->Village }}</td>
                                <td>{{ $row->district?->District ?? '-' }}</td>
                                <td>{{ $row->PostalCode ?? '-' }}</td>
                                <td>
                                    @if ($row->IsActive)
                                    <span class="badge bg-success">Active</span>@else<span
                                            class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>@canEdit('master.village.index')<a
                                        href="{{ route('master.village.edit', $row->VillageID) }}"
                                        class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                                    @canDelete('master.village.index')<form
                                        action="{{ route('master.village.destroy', $row->VillageID) }}" method="POST"
                                        class="d-inline">@csrf @method('DELETE')<button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menonaktifkan data ini?')"><i
                                                class="bi bi-trash"></i></button></form>@endcanDelete</td>
                        </tr>@empty<tr>
                                <td colspan="8" class="text-center">Tidak ada data Village.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>{{ $villages->links() }}
        </div>
    </div>
@endsection
