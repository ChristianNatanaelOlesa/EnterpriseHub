@extends('layouts.app')

@section('title', 'Province Detail')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Province Detail</h4>

        <a
            href="{{ route('master.province.index') }}"
            class="btn btn-secondary"
        >
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

    <x-card>
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Province ID
                </label>

                <div>
                    {{ $province->ProvinceID }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Province
                </label>

                <div>
                    {{ $province->Province }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Country
                </label>

                <div>
                    {{ $province->country?->Country ?? '-' }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">
                    Status
                </label>

                <div>
                    @if ($province->IsActive)
                        <span class="badge bg-success">
                            Active
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

        </div>
    </x-card>

</div>
@endsection