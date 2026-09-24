@extends('layouts.app')

@section('title', 'Currency')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Currency</h5>
        @canAdd('master.currency.index')
            <a href="{{ route('master.currency.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        @endcanAdd
    </div>

    <div class="card-body">
        <x-alert />
        <form method="GET" action="{{ route('master.currency.index') }}" class="row g-2 mb-3">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari ID atau nama currency..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
            @if(request('search'))<div class="col-auto"><a href="{{ route('master.currency.index') }}" class="btn btn-secondary">Reset</a></div>@endif
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead><tr><th width="60">#</th><th>Currency ID</th><th>Currency</th><th>Priority</th><th width="120">Status</th><th width="150">Action</th></tr></thead>
                <tbody>
                    @forelse($currencies as $row)
                        <tr>
                            <td>{{ $currencies->firstItem() + $loop->index }}</td>
                            <td>{{ $row->CcyID }}</td>
                            <td>{{ $row->Currency }}</td>
                            <td>{{ $row->Priority }}</td>
                            <td>@if($row->IsActive)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif</td>
                            <td class="text-nowrap">
                                @canEdit('master.currency.index')<a href="{{ route('master.currency.edit', $row->CcyID) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                                @canDelete('master.currency.index')<form action="{{ route('master.currency.destroy', $row->CcyID) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menonaktifkan data ini?')"><i class="bi bi-trash"></i></button></form>@endcanDelete
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Tidak ada data Currency.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $currencies->links() }}
    </div>
</div>
@endsection
