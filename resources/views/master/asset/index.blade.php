@extends('layouts.app')

@section('title', 'Asset')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Asset</h5>
        @canAdd('master.asset.index')
            <a href="{{ route('master.asset.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        @endcanAdd
    </div>

    <div class="card-body">
        <x-alert />
        <form method="GET" action="{{ route('master.asset.index') }}" class="row g-2 mb-3">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari ID, QR Code, brand, model, atau serial no..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
            @if(request('search'))<div class="col-auto"><a href="{{ route('master.asset.index') }}" class="btn btn-secondary">Reset</a></div>@endif
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead><tr><th>#</th><th>Asset ID</th><th>QR Code</th><th>Asset Type</th><th>Brand</th><th>Model</th><th>Serial No</th><th>Vendor</th><th>Purchase Date</th><th>Currency</th><th>Acq Cost</th><th>Warranty</th><th>ISO</th><th>Status</th><th width="150">Action</th></tr></thead>
                <tbody>
                    @forelse($assets as $row)
                        <tr>
                            <td>{{ $assets->firstItem() + $loop->index }}</td>
                            <td>{{ $row->AssetID }}</td>
                            <td><code>{{ $row->QRCode }}</code></td>
                            <td>{{ $row->assetType?->AssetType ?? $row->AssTypeID }}</td>
                            <td>{{ $row->Brand }}</td>
                            <td>{{ $row->Model }}</td>
                            <td>{{ $row->SerialNo }}</td>
                            <td>{{ $row->VendorID ?? '-' }}</td>
                            <td>{{ $row->PurchaseDate?->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $row->CcyID }}</td>
                            <td>{{ number_format((float) $row->AcqCost, 2, '.', ',') }}</td>
                            <td>@if($row->IsWarranty)<span class="badge bg-success">Yes</span>@else<span class="badge bg-secondary">No</span>@endif</td>
                            <td>@if($row->IsISO)<span class="badge bg-primary">ISO</span>@else<span class="badge bg-secondary">No</span>@endif</td>
                            <td>@if($row->IsActive)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif</td>
                            <td class="text-nowrap">
                                @canEdit('master.asset.index')<a href="{{ route('master.asset.edit', $row->AssetID) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                                @canDelete('master.asset.index')<form action="{{ route('master.asset.destroy', $row->AssetID) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menonaktifkan data ini?')"><i class="bi bi-trash"></i></button></form>@endcanDelete
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="15" class="text-center">Tidak ada data Asset.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $assets->links() }}
    </div>
</div>
@endsection
