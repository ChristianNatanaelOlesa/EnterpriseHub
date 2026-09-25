@extends('layouts.app')

@section('title', 'Master Code Of Conduct')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Master Code Of Conduct</h4>
            <div class="text-muted small">Code Of Conduct master data</div>
        </div>

        @canAdd('master.coc.index')
        <a href="{{ route('master.coc.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Create
        </a>
        @endcanAdd
    </div>

    <x-alert />

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-8">
                    <input name="search" class="form-control" value="{{ request('search') }}"
                        placeholder="Search Coc ID, name, or description...">
                </div>

                <div class="col-md-auto">
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-search me-1"></i>Search
                    </button>
                </div>

                @if (request('search'))
                    <div class="col-md-auto">
                        <a href="{{ route('master.coc.index') }}" class="btn btn-outline-secondary">
                            Clear
                        </a>
                    </div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Coc ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>File</th>
                            <th>Input User</th>
                            <th>Input Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ $data->firstItem() + $loop->index }}</td>

                                <td>{{ $item->CocID }}</td>

                                <td>{{ $item->Name }}</td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($item->Description, 80) }}
                                </td>

                                <td>
                                    @if ($item->FileLoc)
                                        <a href="{{ route('master.coc.download', $item->CocID) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download me-1"></i>File
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>{{ $item->InputUser }}</td>

                                <td>
                                    {{ $item->InputDate?->format('d/m/Y H:i') ?? '-' }}
                                </td>

                                <td class="text-end text-nowrap">
                                    @canEdit('master.coc.index')
                                    <a href="{{ route('master.coc.edit', $item->CocID) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcanEdit

                                    @canDelete('master.coc.index')
                                    <form action="{{ route('master.coc.destroy', $item->CocID) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this data?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcanDelete
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="99" class="text-center py-5 text-muted">
                                    No Code Of Conduct found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Showing {{ $data->firstItem() ?? 0 }}
                    to {{ $data->lastItem() ?? 0 }}
                    of {{ $data->total() }} results
                </div>

                {{ $data->links() }}
            </div>

        </div>
    </div>

@endsection
