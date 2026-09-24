@extends('layouts.app')
@section('title', 'Job Title')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Job Title</h5>
        @canAdd('master.job-title.index')
            <a href="{{ route('master.job-title.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
        @endcanAdd
    </div>
    <div class="card-body">
        <x-alert />
        <form method="GET" action="{{ route('master.job-title.index') }}" class="row g-2 mb-3">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari job title..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button type="submit" class="btn btn-primary">Search</button></div>
            @if(request('search'))<div class="col-auto"><a href="{{ route('master.job-title.index') }}" class="btn btn-secondary">Reset</a></div>@endif
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead><tr><th width="60">#</th><th>Job Title</th><th width="120">Status</th><th width="150">Action</th></tr></thead>
                <tbody>
                @forelse($jobTitles as $jobTitle)
                    <tr>
                        <td>{{ $jobTitles->firstItem() + $loop->index }}</td>
                        <td>{{ $jobTitle->JobTitle }}</td>
                        <td>@if($jobTitle->IsActive)<span class="badge bg-success">Active</span>@else<span class="badge bg-secondary">Inactive</span>@endif</td>
                        <td>
                            @canEdit('master.job-title.index')<a href="{{ route('master.job-title.edit', $jobTitle->JobTitleID) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>@endcanEdit
                            @canDelete('master.job-title.index')
                            <form action="{{ route('master.job-title.destroy', $jobTitle->JobTitleID) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus Job Title ini?')"><i class="bi bi-trash"></i></button></form>
                            @endcanDelete
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Tidak ada data Job Title.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $jobTitles->links() }}
    </div>
</div>
@endsection
