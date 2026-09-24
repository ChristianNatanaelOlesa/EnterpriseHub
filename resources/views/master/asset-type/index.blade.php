@extends('layouts.app')

@section('title', 'Asset Type')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Asset Type</h5>
        @canAdd('master.asset-type.index')
            <a href="{{ route('master.asset-type.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        @endcanAdd
    </div>

    <div class="card-body">
        <x-alert />
        <form method="GET" action="{{ route('master.asset-type.index') }}" class="row g-2 mb-3">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari ID atau nama asset type..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
            @if(request('search'))<div class="col-auto"><a href="{{ route('master.asset-type.index') }}" class="btn btn-secondary">Reset</a></div>@endif
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead><tr><th width="60">#</th><th>Asset Type ID</th><th>Asset Group</th><th>Asset Type</th><th>Description</th><th width="120">Status</th><th width="150">Action</th></tr></thead>
                <tbody>
                    @forelse($assetTypes as $row)
                        <tr>
                            <td>{{ $assetTypes->firstItem() + $loop->index }}</td>
                            <td>{{ $row->AssTypeID }}</td>
                            <td>{{ $row->assetGroup?->AssetGroup ?? $row->AssetGroupID }}</td>
                            <td>{{ $row->AssetType }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($row->TypeDesc, 60) }}</td>
                            <td>@if($row->IsActive)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif</td>
                            <td class="text-nowrap">
                                @canEdit('master.asset-type.index')<a href="{{ route('master.asset-type.edit', $row->AssTypeID) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                                @canDelete('master.asset-type.index')<form action="{{ route('master.asset-type.destroy', $row->AssTypeID) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menonaktifkan data ini?')"><i class="bi bi-trash"></i></button></form>@endcanDelete
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data Asset Type.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $assetTypes->links() }}
    </div>
</div>
@endsection
