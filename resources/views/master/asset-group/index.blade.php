@extends('layouts.app')

@section('title', 'Asset Group')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Asset Group</h5>
            @canAdd('master.asset-group.index')
            <a href="{{ route('master.asset-group.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah
            </a>
            @endcanAdd
        </div>

        <div class="card-body">
            <x-alert />

            <form method="GET" action="{{ route('master.asset-group.index') }}" class="row g-2 mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari ID atau nama asset group..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                @if (request('search'))
                    <div class="col-auto"><a href="{{ route('master.asset-group.index') }}"
                            class="btn btn-secondary">Reset</a></div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Asset Group ID</th>
                            <th>Asset Group</th>
                            <th>Description</th>
                            <th>Com. Lifetime</th>
                            <th>Fiscal Lifetime</th>
                            <th width="120">Status</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assetGroups as $row)
                            <tr>
                                <td>{{ $assetGroups->firstItem() + $loop->index }}</td>
                                <td>{{ $row->AssGroupID }}</td>
                                <td>{{ $row->AssetGroup }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($row->Description, 60) }}</td>
                                <td>{{ $row->ComLifetime }}</td>
                                <td>{{ $row->FiscalLifetime }}</td>
                                <td>
                                    @if ($row->IsActive)
                                    <span class="badge bg-success">Active</span>@else<span
                                            class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @canEdit('master.asset-group.index')
                                    <a href="{{ route('master.asset-group.edit', $row->AssGroupID) }}"
                                        class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    @endcanEdit
                                    @canDelete('master.asset-group.index')
                                    <form action="{{ route('master.asset-group.destroy', $row->AssGroupID) }}"
                                        method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menonaktifkan data ini?')"><i
                                                class="bi bi-trash"></i></button></form>
                                    @endcanDelete
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data Asset Group.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $assetGroups->links() }}
        </div>
    </div>
@endsection
