@extends('layouts.app')

@section('title','Company')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h5>Company</h5>

        <a href="{{ route('company.create') }}"
           class="btn btn-primary">

            Tambah

        </a>

    </div>

    <form>

        <input
            type="text"
            name="search"
            value="{{ request('search') }}">

        <button>

            Search

        </button>

    </form>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

            <tr>

                <th>Kode</th>

                <th>Nama</th>

                <th>Status</th>

                <th width="180">Action</th>

            </tr>

            </thead>

            <tbody>

            @foreach($companies as $company)

                <tr>

                    <td>{{ $company->CompanyCode }}</td>

                    <td>{{ $company->CompanyName }}</td>

                    <td>

                        {{ $company->IsActive ? 'Active':'Inactive' }}

                    </td>

                    <td>

                        Edit

                        Delete

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

        {{ $companies->links() }}

    </div>

</div>

@endsection