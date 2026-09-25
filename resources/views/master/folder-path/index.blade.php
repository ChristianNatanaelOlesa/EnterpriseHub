@extends('layouts.app')

@section('title', 'Folder Path')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Folder Path</h4>
            <div class="text-muted">Sharing Folder Path Master</div>
        </div>

        <a href="{{ route('master.folder-path.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Add Folder Path
        </a>
    </div>

    <x-alert />

    <div class="card">

        <div class="card-body">

            <form method="GET" action="{{ route('master.folder-path.index') }}" class="row g-2 mb-3">

                <div class="col-md-8">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search anything..."
                    >
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search me-1"></i>
                        Search
                    </button>
                </div>

                @if(request('search'))
                    <div class="col-auto">
                        <a href="{{ route('master.folder-path.index') }}" class="btn btn-outline-secondary">
                            Clear
                        </a>
                    </div>
                @endif

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th width="55">#</th>
                            <th>Folder ID</th>
                            <th>Folder Name</th>
                            <th>Folder Path</th>
                            <th>Parent Folder</th>
                            <th class="text-center">Active</th>
                            <th class="text-center" width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($data as $item)

                        <tr>

                            <td>
                                {{ $data->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $item->FolderPathID }}
                            </td>

                            <td>
                                {{ $item->FolderName }}
                            </td>

                            <td>
                                <code>{{ $item->FolderPath }}</code>
                            </td>

                            <td>
                                {{ $item->parent?->FolderName ?? '-' }}
                            </td>

                            <td class="text-center">
                                @if($item->IsActive)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>

                            <td class="text-center">

                                @canEdit('master.folder-path.index')
                                    <a
                                        href="{{ route('master.folder-path.edit', $item->FolderPathID) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endcanEdit

                                @canDelete('master.folder-path.index')
                                    <form
                                        action="{{ route('master.folder-path.destroy', $item->FolderPathID) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus Folder Path ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endcanDelete

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                No Folder Path found.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $data->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
