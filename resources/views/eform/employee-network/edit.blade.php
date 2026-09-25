@extends('layouts.app')

@section('title', 'Edit Employee Network')

@section('content')

    <div class="container-fluid">

        {{-- ========================================================= --}}
        {{-- Page Header --}}
        {{-- ========================================================= --}}
        <div class="mb-4">

            <h4 class="mb-1">
                Edit Employee Network Request
            </h4>

            <div class="text-muted">
                Update employee network request
            </div>

        </div>


        <x-alert />


        <form method="POST" action="{{ route('employee-network.update', $data->EmpNetworkID) }}">

            @csrf

            @method('PUT')


            {{-- ========================================================= --}}
            {{-- Employee Information --}}
            {{-- ========================================================= --}}
            <div class="card mb-3">

                <div class="card-header">

                    <h5 class="mb-0">
                        Employee Information
                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-3">


                        {{-- Employee Network ID --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Employee Network ID
                            </label>

                            <input type="text" class="form-control" value="{{ $data->EmpNetworkID }}" readonly>

                        </div>


                        {{-- Emp Form ID --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Emp Form ID
                            </label>

                            <input type="text" class="form-control" value="{{ $data->EmpFormID }}" readonly>

                        </div>


                        {{-- Request Date --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Request Date
                            </label>

                            <input type="text" class="form-control" value="{{ $data->ReqDate?->format('d/m/Y') ?? '-' }}"
                                readonly>

                        </div>


                        {{-- Request User --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Request User
                            </label>

                            <input type="text" class="form-control" value="{{ $data->ReqUser ?? '-' }}" readonly>

                        </div>


                        {{-- Division --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Division
                            </label>

                            <input type="text" class="form-control" value="{{ $division?->DivisionName ?? '-' }}"
                                readonly>

                            <input type="hidden" name="ReqDivID" value="{{ $data->ReqDivID }}">

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Network Request --}}
            {{-- ========================================================= --}}
            <div class="card mb-3">

                <div class="card-header">

                    <h5 class="mb-0">
                        Network Request
                    </h5>

                </div>


                <div class="card-body">

                    <div class="row g-3">


                        {{-- ================================================= --}}
                        {{-- Request Type --}}
                        {{-- ================================================= --}}
                        <div class="col-md-4">

                            <label for="ReqType" class="form-label">

                                Request Type

                                <span class="text-danger">
                                    *
                                </span>

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
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- ================================================= --}}
                        {{-- Date From --}}
                        {{-- ================================================= --}}
                        <div class="col-md-4">

                            <label for="DateFrom" class="form-label">

                                Date From

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="date" name="DateFrom" id="DateFrom"
                                class="form-control @error('DateFrom') is-invalid @enderror"
                                value="{{ old('DateFrom', $data->DateFrom?->format('Y-m-d')) }}" required>


                            @error('DateFrom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- ================================================= --}}
                        {{-- Date Until --}}
                        {{-- ================================================= --}}
                        <div class="col-md-4">

                            <label for="DateUntil" class="form-label">

                                Date Until

                            </label>


                            <input type="date" name="DateUntil" id="DateUntil"
                                class="form-control @error('DateUntil') is-invalid @enderror"
                                value="{{ old('DateUntil', $data->DateUntil?->format('Y-m-d')) }}">


                            @error('DateUntil')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- ================================================= --}}
                        {{-- Network Access --}}
                        {{-- ================================================= --}}
                        <div class="col-12">

                            <label class="form-label">
                                Network Access
                            </label>


                            <div class="d-flex align-items-center gap-4 mt-2">


                                {{-- Internet --}}
                                <div class="form-check form-switch">

                                    <input class="form-check-input" type="checkbox" role="switch" name="InternetAccess"
                                        id="InternetAccess" value="1" @checked(old('InternetAccess', $data->InternetAccess))>

                                    <label class="form-check-label" for="InternetAccess">
                                        Internet Access
                                    </label>

                                </div>


                                {{-- WLAN --}}
                                <div class="form-check form-switch">

                                    <input class="form-check-input" type="checkbox" role="switch" name="WLANAccess"
                                        id="WLANAccess" value="1" @checked(old('WLANAccess', $data->WLANAccess))>

                                    <label class="form-check-label" for="WLANAccess">
                                        WLAN Access
                                    </label>

                                </div>


                                {{-- VPN --}}
                                <div class="form-check form-switch">

                                    <input class="form-check-input" type="checkbox" role="switch" name="VPNAccess"
                                        id="VPNAccess" value="1" @checked(old('VPNAccess', $data->VPNAccess))>

                                    <label class="form-check-label" for="VPNAccess">
                                        VPN Access
                                    </label>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- Purpose --}}
                        {{-- ================================================= --}}
                        <div class="col-12">

                            <label for="Purpose" class="form-label">

                                Purpose

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <textarea name="Purpose" id="Purpose" rows="3" class="form-control @error('Purpose') is-invalid @enderror"
                                required>{{ old('Purpose', $data->Purpose) }}</textarea>


                            @error('Purpose')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- ================================================= --}}
                        {{-- Notes --}}
                        {{-- ================================================= --}}
                        <div class="col-12">

                            <label for="Notes" class="form-label">
                                Notes
                            </label>


                            <textarea name="Notes" id="Notes" rows="3" class="form-control @error('Notes') is-invalid @enderror">{{ old('Notes', $data->Notes ?: '-') }}</textarea>


                            @error('Notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- Action --}}
            {{-- ========================================================= --}}
            <div class="d-flex justify-content-end gap-2 mb-4">

                <a href="{{ route('employee-network.index') }}" class="btn btn-secondary">
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


{{-- ============================================================= --}}
{{-- Scripts --}}
{{-- ============================================================= --}}
@push('scripts')
    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const reqType =
                    document.getElementById('ReqType');

                const dateFrom =
                    document.getElementById('DateFrom');

                const dateUntil =
                    document.getElementById('DateUntil');


                function syncDateUntil() {

                    const permanent =
                        reqType.value === 'Permanent';


                    if (permanent) {

                        dateUntil.value =
                            '1900-01-01';

                        dateUntil.readOnly =
                            true;

                        dateUntil.classList.add(
                            'readonly-field'
                        );

                        dateUntil.removeAttribute(
                            'min'
                        );

                    } else {

                        dateUntil.readOnly =
                            false;

                        dateUntil.classList.remove(
                            'readonly-field'
                        );

                        dateUntil.min =
                            dateFrom.value || '';


                        if (
                            !dateUntil.value ||
                            dateUntil.value === '1900-01-01'
                        ) {

                            dateUntil.value =
                                dateFrom.value || '';

                        }

                    }

                }


                reqType.addEventListener(
                    'change',
                    syncDateUntil
                );


                dateFrom.addEventListener(
                    'change',
                    function() {

                        if (
                            reqType.value === 'Temporary'
                        ) {

                            dateUntil.min =
                                dateFrom.value || '';


                            if (
                                dateUntil.value &&
                                dateUntil.value !== '1900-01-01' &&
                                dateUntil.value < dateFrom.value
                            ) {

                                dateUntil.value =
                                    dateFrom.value;

                            }

                        }

                    }
                );


                syncDateUntil();

            }
        );
    </script>
@endpush
