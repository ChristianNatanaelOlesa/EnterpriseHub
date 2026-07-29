@extends('layouts.app')

@section('title','Company')

@section('content')

<x-alert />

<x-toolbar title="Company">

    <a href="{{ route('companies.create') }}"
       class="btn btn-primary">

        <i class="bi bi-plus"></i>

        Add Company

    </a>

</x-toolbar>

<x-card>

<table class="table table-hover">

    <thead>

        <tr>

            <th width="80">Code</th>
            <th>Name</th>
            <th width="120">Status</th>
            <th width="180">Action</th>

        </tr>

    </thead>

    <tbody>

    @forelse($companies as $company)

        <tr>

            <td>{{ $company->CompanyCode }}</td>

            <td>{{ $company->CompanyName }}</td>

            <td>

                @if($company->IsActive)

                    <span class="badge bg-success">

                        Active

                    </span>

                @else

                    <span class="badge bg-danger">

                        Inactive

                    </span>

                @endif

            </td>

            <td>
                <a href="{{ route('companies.edit', $company) }}"
                class="btn btn-warning btn-sm">
                    Edit
                </a>

                <form method="POST"
                    action="{{ route('companies.destroy', $company) }}"
                    class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                        Delete
                    </button>

                </form>
            </td>

        </tr>

    @empty

        <tr>

            <td colspan="4" class="text-center">

                No Data

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

</x-card>

@endsection