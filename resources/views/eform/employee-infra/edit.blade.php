@extends('layouts.app')

@section('title', 'Edit Employee Infrastructure')

@section('content')

    <div class="container-fluid">

        <div class="mb-4">
            <h4 class="mb-1">Edit Employee Infrastructure Request</h4>
            <div class="text-muted">Update employee infrastructure request</div>
        </div>

        <x-alert />

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please check the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('employee-infra.update', $data->EmpInfraID) }}">
            @csrf
            @method('PUT')

            {{-- ========================================================= --}}
            {{-- Employee Information --}}
            {{-- ========================================================= --}}
            <div class="card mb-3">

                <div class="card-header">
                    <h5 class="mb-0">Employee Information</h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Employee Infrastructure ID</label>
                            <input type="text" class="form-control" value="{{ $data->EmpInfraID }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Emp Form ID</label>
                            <input type="text" class="form-control" value="{{ $data->EmpFormID }}" readonly>
                        </div>

                        <div class="col-md-4"></div>

                        <div class="col-md-4">
                            <label class="form-label">Request Date</label>
                            <input type="text" class="form-control" value="{{ $data->ReqDate?->format('d/m/Y') ?? '-' }}"
                                readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Request User</label>
                            <input type="text" class="form-control" value="{{ $data->ReqUser ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Division</label>
                            <input type="text" class="form-control" value="{{ $division?->DivisionName ?? '-' }}"
                                readonly>
                        </div>

                    </div>

                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- Infrastructure Request --}}
            {{-- ========================================================= --}}
            <div class="card mb-3">

                <div class="card-header">
                    <h5 class="mb-0">Infrastructure Request</h5>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label for="ReqType" class="form-label">
                                Request Type <span class="text-danger">*</span>
                            </label>

                            <select name="ReqType" id="ReqType" class="form-select @error('ReqType') is-invalid @enderror"
                                required>
                                <option value="Permanent" @selected(old('ReqType', $data->ReqType) === 'Permanent')>
                                    Permanent
                                </option>
                                <option value="Temporary" @selected(old('ReqType', $data->ReqType) === 'Temporary')>
                                    Temporary
                                </option>
                            </select>

                            @error('ReqType')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="DateFrom" class="form-label">
                                Date From <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="DateFrom" id="DateFrom"
                                class="form-control @error('DateFrom') is-invalid @enderror"
                                value="{{ old('DateFrom', $data->DateFrom?->format('Y-m-d')) }}" required>

                            @error('DateFrom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="DateUntil" class="form-label">Date Until</label>

                            <input type="date" name="DateUntil" id="DateUntil"
                                class="form-control @error('DateUntil') is-invalid @enderror"
                                value="{{ old('DateUntil', $data->DateUntil?->format('Y-m-d')) }}">

                            @error('DateUntil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="AccessType" class="form-label">
                                Access Type <span class="text-danger">*</span>
                            </label>

                            <select name="AccessType" id="AccessType"
                                class="form-select @error('AccessType') is-invalid @enderror" required>
                                <option value="Personal" @selected(old('AccessType', $data->AccessType) === 'Personal')>
                                    Personal
                                </option>
                                <option value="Server" @selected(old('AccessType', $data->AccessType) === 'Server')>
                                    Server
                                </option>
                            </select>

                            @error('AccessType')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">
                                Access Area <span class="text-danger">*</span>
                            </label>

                            <input type="text" class="form-control" value="{{ $data->AccessArea ?: 'Akun Windows' }}"
                                readonly>
                        </div>

                        <div class="col-md-4">
                            <label for="UserLogin" class="form-label">
                                User Login <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="UserLogin" id="UserLogin"
                                class="form-control @error('UserLogin') is-invalid @enderror"
                                value="{{ old('UserLogin', $data->UserLogin) }}" maxlength="100" required>

                            @error('UserLogin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="Purpose" class="form-label">
                                Purpose <span class="text-danger">*</span>
                            </label>

                            <textarea name="Purpose" id="Purpose" rows="3" class="form-control @error('Purpose') is-invalid @enderror"
                                required>{{ old('Purpose', $data->Purpose) }}</textarea>

                            @error('Purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="Notes" class="form-label">Notes</label>

                            <textarea name="Notes" id="Notes" rows="3" class="form-control @error('Notes') is-invalid @enderror">{{ old('Notes', $data->Notes ?: '-') }}</textarea>

                            @error('Notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>

            </div>

            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('employee-infra.index') }}" class="btn btn-secondary">
                    Close
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    Update
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const reqType = document.getElementById('ReqType');
            const dateFrom = document.getElementById('DateFrom');
            const dateUntil = document.getElementById('DateUntil');

            function syncDateUntil() {
                if (reqType.value === 'Permanent') {
                    dateUntil.value = '1900-01-01';
                    dateUntil.readOnly = true;
                    dateUntil.removeAttribute('min');
                } else {
                    dateUntil.readOnly = false;
                    dateUntil.min = dateFrom.value || '';

                    if (!dateUntil.value || dateUntil.value === '1900-01-01') {
                        dateUntil.value = dateFrom.value || '';
                    }
                }
            }

            reqType.addEventListener('change', syncDateUntil);

            dateFrom.addEventListener('change', function() {
                if (reqType.value === 'Temporary') {
                    dateUntil.min = dateFrom.value || '';

                    if (
                        dateUntil.value &&
                        dateUntil.value !== '1900-01-01' &&
                        dateUntil.value < dateFrom.value
                    ) {
                        dateUntil.value = dateFrom.value;
                    }
                }
            });

            syncDateUntil();
        });
    </script>
@endpush
