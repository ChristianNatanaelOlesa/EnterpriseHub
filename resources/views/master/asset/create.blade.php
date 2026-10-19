@extends('layouts.app')

@section('title', 'Create Asset')

@section('content')

    <x-alert />

    <x-card>

        <div class="card-header">
            <h5 class="mb-0">Create Asset</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('master.asset.store') }}">

                @csrf

                <div class="row">

                    {{-- Asset Type --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Asset Type
                            <span class="text-danger">*</span>
                        </label>

                        <select name="AssTypeID" class="form-select" required>

                            <option value="">
                                -- Select Asset Type --
                            </option>

                            @foreach ($assetTypes as $type)
                                <option value="{{ $type->AssTypeID }}" @selected(old('AssTypeID') === $type->AssTypeID)>
                                    {{ $type->AssTypeID }}
                                    -
                                    {{ $type->AssetType }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Asset ID --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Asset ID
                        </label>

                        <input type="text" class="form-control readonly-field" value="AUTO" readonly>

                    </div>


                    {{-- QR Code --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            QR Code
                        </label>

                        <input type="text" class="form-control readonly-field" value="AUTO" readonly>

                    </div>


                    {{-- Asset Description --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Asset Description
                            <span class="text-danger">*</span>
                        </label>

                        <textarea name="AssetDesc" class="form-control" rows="3" required>{{ old('AssetDesc') }}</textarea>

                    </div>


                    {{-- Brand --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Brand
                            <span class="text-danger">*</span>
                        </label>

                        <input name="Brand" class="form-control" value="{{ old('Brand') }}" required>

                    </div>


                    {{-- Model --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Model
                            <span class="text-danger">*</span>
                        </label>

                        <input name="Model" class="form-control" value="{{ old('Model') }}" required>

                    </div>


                    {{-- Serial No --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Serial No
                            <span class="text-danger">*</span>
                        </label>

                        <input name="SerialNo" class="form-control" value="{{ old('SerialNo') }}" required>

                    </div>


                    {{-- Color --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Color
                            <span class="text-danger">*</span>
                        </label>

                        <input name="Color" class="form-control" value="{{ old('Color') }}" required>

                    </div>


                    {{-- Specification --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Specification
                            <span class="text-danger">*</span>
                        </label>

                        <textarea name="Specification" class="form-control" rows="4" required>{{ old('Specification') }}</textarea>

                    </div>


                    {{-- Notes --}}
                    <div class="col-12 mb-3">

                        <label class="form-label">
                            Notes
                        </label>

                        <textarea name="Notes" class="form-control" rows="3">{{ old('Notes', '-') }}</textarea>

                    </div>


                    {{-- Vendor ID --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Vendor ID
                        </label>

                        <select name="VendorID" class="form-select">
                            <option value="">-- Pilih Vendor --</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor->VendorID }}" @selected(old('VendorID') === $vendor->VendorID)>
                                    {{ $vendor->VendorID }} - {{ $vendor->Vendor }}
                                </option>
                            @endforeach
                        </select>

                    </div>


                    {{-- Purchase Date --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Purchase Date
                        </label>

                        <input type="date" name="PurchaseDate" class="form-control" value="{{ old('PurchaseDate') }}">

                    </div>


                    {{-- Currency --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Currency
                            <span class="text-danger">*</span>
                        </label>

                        <select name="CcyID" id="CcyID" class="form-select" required>

                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->CcyID }}" @selected(old('CcyID', 'IDR') === $currency->CcyID)>
                                    {{ $currency->CcyID }}
                                    -
                                    {{ $currency->Currency }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- Exchange Rate --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Exchange Rate
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" step="0.0001" min="0" name="ExchRate" id="ExchRate"
                            class="form-control" value="{{ old('ExchRate', 1) }}">

                    </div>


                    {{-- Acquisition Cost --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Acquisition Cost
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" step="0.01" min="0" name="AcqCost" id="AcqCost"
                            class="form-control" value="{{ old('AcqCost', 0) }}" required>

                    </div>


                    {{-- Acquisition Cost IDR --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Acquisition Cost IDR
                        </label>

                        <input type="number" step="0.01" min="0" name="AcqCostIDR" id="AcqCostIDR"
                            class="form-control readonly-field" value="{{ old('AcqCostIDR', 0) }}" readonly>

                    </div>


                    {{-- Warranty --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Warranty
                        </label>

                        <div class="form-check form-switch mt-2">

                            <input type="hidden" name="IsWarranty" value="0">

                            <input class="form-check-input" type="checkbox" name="IsWarranty" value="1"
                                id="IsWarranty" @checked(old('IsWarranty', false))>

                        </div>

                    </div>


                    {{-- Warranty Date --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Warranty Date
                        </label>

                        <input type="date" name="WarrantyDate" id="WarrantyDate" class="form-control"
                            value="{{ old('WarrantyDate', '1900-01-01') }}">

                    </div>


                    {{-- ISO Asset --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            ISO Asset
                        </label>

                        <div class="form-check form-switch mt-2">

                            <input type="hidden" name="IsISO" value="0">

                            <input class="form-check-input" type="checkbox" name="IsISO" value="1"
                                id="IsISO" @checked(old('IsISO', false))>

                        </div>

                    </div>


                    {{-- Active --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Active
                        </label>

                        <div class="form-check form-switch mt-2">

                            <input type="hidden" name="IsActive" value="0">

                            <input class="form-check-input" type="checkbox" name="IsActive" value="1"
                                id="IsActive" @checked(old('IsActive', true))>

                        </div>

                    </div>

                </div>


                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>

                    <a href="{{ route('master.asset.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </x-card>

@endsection


@push('styles')
    <style>
        .readonly-field {
            background-color: #e9ecef !important;
            color: #495057 !important;
            cursor: not-allowed;
        }
    </style>
@endpush


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const c =
                document.getElementById('CcyID');

            const r =
                document.getElementById('ExchRate');

            const cost =
                document.getElementById('AcqCost');

            const idr =
                document.getElementById('AcqCostIDR');

            const w =
                document.getElementById('IsWarranty');

            const wd =
                document.getElementById('WarrantyDate');


            function sync() {

                r.readOnly =
                    c.value === 'IDR';

                r.classList.toggle(
                    'readonly-field',
                    c.value === 'IDR'
                );

                if (c.value === 'IDR') {

                    r.value = '1';

                }

                idr.value = (
                    (parseFloat(cost.value) || 0) *
                    (parseFloat(r.value) || 1)
                ).toFixed(2);

            }


            function warranty() {

                const on = w.checked;

                wd.readOnly = !on;

                wd.classList.toggle(
                    'readonly-field',
                    !on
                );

                if (!on) {

                    wd.value = '1900-01-01';

                } else if (
                    wd.value === '1900-01-01'
                ) {

                    wd.value = '';

                }

            }


            c.addEventListener(
                'change',
                sync
            );

            r.addEventListener(
                'input',
                sync
            );

            cost.addEventListener(
                'input',
                sync
            );

            w.addEventListener(
                'change',
                warranty
            );


            sync();

            warranty();

        });
    </script>
@endpush
