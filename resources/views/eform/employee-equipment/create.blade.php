@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h4 class="mb-1">Employee Equipment Request</h4>
        <div class="text-muted">
            Create Employee Equipment Request
        </div>
    </div>

    <x-alert />

    <form
        method="POST"
        action="{{ route('employee-equipment.store') }}"
        id="employeeEquipmentForm"
    >

        @csrf


        {{-- =========================================================
            FORM INFORMATION
        ========================================================== --}}
        <div class="card shadow-sm mb-3">

            <div class="card-header bg-white">
                <strong>FORM : EMPLOYEE EQUIPMENT</strong>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Emp Form ID
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ $empForm?->EmpFormID ?? session('EmpFormID', '-') }}"
                            readonly
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Req User
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ auth()->user()->Username ?? '-' }}"
                            readonly
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Req Date
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="{{ now()->format('d - m - Y') }}"
                            readonly
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Request Type
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="ReqType"
                            id="ReqType"
                            class="form-select"
                            required
                        >

                            <option
                                value="Permanent"
                                @selected(old('ReqType', 'Permanent') === 'Permanent')
                            >
                                Permanent
                            </option>

                            <option
                                value="Temporary"
                                @selected(old('ReqType') === 'Temporary')
                            >
                                Temporary
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date From
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="DateFrom"
                            class="form-control"
                            value="{{ old('DateFrom', now()->toDateString()) }}"
                            required
                        >

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date Until
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="DateUntil"
                            id="DateUntil"
                            class="form-control"
                            value="{{ old('DateUntil', '1900-01-01') }}"
                            required
                        >

                    </div>


                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Purpose
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            name="Purpose"
                            rows="3"
                            class="form-control"
                            required
                        >{{ old('Purpose', 'Kebutuhan Pekerjaan') }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            ASSET
        ========================================================== --}}
        <div class="card shadow-sm">

            <div class="card-header bg-white">
                <strong>Asset</strong>
            </div>

            <div class="card-body">


                {{-- =================================================
                    FILTER
                ================================================== --}}
                <div class="row align-items-end mb-3">

                    <div class="col-md-5">

                        <label class="form-label">
                            Asset Type
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="AssetTypeID"
                            id="AssetTypeID"
                            class="form-select"
                        >

                            <option value="">
                                -- Select Asset Type --
                            </option>

                            @foreach ($assetTypes as $type)

                                <option
                                    value="{{ $type->AssTypeID }}"
                                    @selected(
                                        (string) $assetTypeId ===
                                        (string) $type->AssTypeID
                                    )
                                >
                                    {{ $type->AssetType }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-5">

                        <label class="form-label">
                            Search Asset
                        </label>

                        <input
                            type="text"
                            name="asset_search"
                            value="{{ $assetSearch }}"
                            class="form-control"
                            placeholder="Asset ID, brand, model, serial..."
                        >

                    </div>


                    <div class="col-md-2">

                        <button
                            type="button"
                            id="loadAsset"
                            class="btn btn-outline-primary w-100"
                        >
                            Load Asset
                        </button>

                    </div>

                </div>


                {{-- =================================================
                    SELECTED ASSET
                ================================================== --}}
                <div
                    id="selectedAssetSummary"
                    class="border rounded mb-3 d-none"
                >

                    <div class="px-3 py-2 bg-light border-bottom">

                        <div class="d-flex align-items-center">

                            <i class="bi bi-check2-square me-2"></i>

                            <strong>
                                Selected Asset
                            </strong>

                            <span
                                id="selectedAssetCount"
                                class="badge bg-primary ms-2"
                            >
                                0
                            </span>

                        </div>

                    </div>


                    <div class="table-responsive">

                        <table
                            class="table table-sm table-hover align-middle mb-0"
                        >

                            <thead>

                                <tr>

                                    <th>
                                        Asset ID
                                    </th>

                                    <th>
                                        Asset Type
                                    </th>

                                    <th>
                                        Brand
                                    </th>

                                    <th>
                                        Model
                                    </th>

                                    <th>
                                        Serial No
                                    </th>

                                    <th
                                        class="text-center"
                                        style="width: 70px;"
                                    >
                                        Action
                                    </th>

                                </tr>

                            </thead>

                            <tbody
                                id="selectedAssetTableBody"
                            >
                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- =================================================
                    ASSET LIST
                ================================================== --}}
                <div class="table-responsive">

                    <table
                        class="table table-hover align-middle mb-0"
                    >

                        <thead>

                            <tr>

                                <th
                                    class="text-center"
                                    style="width: 60px;"
                                >
                                    ✓
                                </th>

                                <th>
                                    Asset ID
                                </th>

                                <th>
                                    Asset Type
                                </th>

                                <th>
                                    Brand
                                </th>

                                <th>
                                    Model
                                </th>

                                <th>
                                    Serial No
                                </th>

                                <th>
                                    Description
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($assets as $asset)

                                <tr>

                                    <td class="text-center">

                                        <input
                                            type="checkbox"
                                            value="{{ $asset->AssetID }}"
                                            class="form-check-input asset-checkbox"
                                            @checked(
                                                in_array(
                                                    $asset->AssetID,
                                                    old('AssetID', [])
                                                )
                                            )
                                        >

                                    </td>


                                    <td>
                                        {{ $asset->AssetID }}
                                    </td>


                                    <td>
                                        {{ $asset->assetType?->AssetType ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $asset->Brand }}
                                    </td>


                                    <td>
                                        {{ $asset->Model }}
                                    </td>


                                    <td>
                                        {{ $asset->SerialNo }}
                                    </td>


                                    <td>
                                        {{ $asset->AssetDesc }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center text-muted py-4"
                                    >

                                        @if ($assetTypeId)

                                            Tidak ada asset aktif untuk
                                            Asset Type yang dipilih.

                                        @else

                                            Pilih Asset Type terlebih dahulu
                                            untuk menampilkan asset.

                                        @endif

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                    BUTTON
                ================================================== --}}
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('employee-equipment.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-plus-lg me-1"></i>

                        Create

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>


@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | ELEMENTS
        |--------------------------------------------------------------------------
        */

        const form =
            document.getElementById(
                'employeeEquipmentForm'
            );

        const requestType =
            document.getElementById(
                'ReqType'
            );

        const dateUntil =
            document.getElementById(
                'DateUntil'
            );

        const assetType =
            document.getElementById(
                'AssetTypeID'
            );

        const loadAssetButton =
            document.getElementById(
                'loadAsset'
            );

        const selectedAssetSummary =
            document.getElementById(
                'selectedAssetSummary'
            );

        const selectedAssetCount =
            document.getElementById(
                'selectedAssetCount'
            );

        const selectedAssetTableBody =
            document.getElementById(
                'selectedAssetTableBody'
            );


        /*
        |--------------------------------------------------------------------------
        | SELECTED ASSET STATE
        |--------------------------------------------------------------------------
        |
        | Key   = AssetID
        | Value = informasi lengkap asset
        |
        */

        const selectedAssets =
            new Map();


        /*
        |--------------------------------------------------------------------------
        | CURRENT PAGE ASSETS
        |--------------------------------------------------------------------------
        |
        | Data asset yang sedang tampil digunakan
        | untuk menyimpan informasi asset ke selectedAssets.
        |
        */

        @php
            $currentAssets = $assets->map(function ($asset) {
                return [
                    'AssetID' => $asset->AssetID,
                    'AssetType' => $asset->assetType?->AssetType ?? '-',
                    'Brand' => $asset->Brand ?? '-',
                    'Model' => $asset->Model ?? '-',
                    'SerialNo' => $asset->SerialNo ?? '-',
                    'AssetDesc' => $asset->AssetDesc ?? '-',
                ];
            })->values();
        @endphp

        const currentAssets = @json($currentAssets);


        /*
        |--------------------------------------------------------------------------
        | SESSION STORAGE KEY
        |--------------------------------------------------------------------------
        */

        const storageKey =
            'employeeEquipmentSelectedAssets';


        /*
        |--------------------------------------------------------------------------
        | RESTORE SELECTED ASSETS
        |--------------------------------------------------------------------------
        */

        const storedAssets =
            sessionStorage.getItem(
                storageKey
            );


        if (storedAssets) {

            try {

                const parsedAssets =
                    JSON.parse(
                        storedAssets
                    );


                if (
                    parsedAssets &&
                    typeof parsedAssets === 'object'
                ) {

                    Object.keys(
                        parsedAssets
                    ).forEach(
                        function (assetId) {

                            selectedAssets.set(
                                String(assetId),
                                parsedAssets[assetId]
                            );

                        }
                    );

                }

            } catch (error) {

                console.error(
                    'Failed to restore selected assets.',
                    error
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | OLD INPUT
        |--------------------------------------------------------------------------
        |
        | Digunakan kalau validation backend gagal.
        |
        */

        const oldAssetIds =
            @json(old('AssetID', []));


        /*
        |--------------------------------------------------------------------------
        | ADD CURRENT PAGE ASSETS
        |--------------------------------------------------------------------------
        |
        | Kalau asset sebelumnya sudah dichecklist,
        | informasi lengkapnya kita update dari data terbaru.
        |
        */

        currentAssets.forEach(
            function (asset) {

                const assetId =
                    String(
                        asset.AssetID
                    );

                if (
                    selectedAssets.has(
                        assetId
                    )
                ) {

                    selectedAssets.set(
                        assetId,
                        asset
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | HANDLE OLD INPUT
        |--------------------------------------------------------------------------
        |
        | Kalau old AssetID belum punya detail,
        | minimal tampilkan Asset ID-nya.
        |
        */

        oldAssetIds.forEach(
            function (assetId) {

                const id =
                    String(assetId);


                if (
                    !selectedAssets.has(id)
                ) {

                    const currentAsset =
                        currentAssets.find(
                            function (asset) {

                                return String(
                                    asset.AssetID
                                ) === id;

                            }
                        );


                    selectedAssets.set(
                        id,
                        currentAsset ?? {

                            AssetID: id,
                            AssetType: '-',
                            Brand: '-',
                            Model: '-',
                            SerialNo: '-',
                            AssetDesc: '-'

                        }
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SAVE STATE
        |--------------------------------------------------------------------------
        */

        function saveSelectedAssets() {

            const data = {};

            selectedAssets.forEach(
                function (
                    asset,
                    assetId
                ) {

                    data[assetId] =
                        asset;

                }
            );


            sessionStorage.setItem(
                storageKey,
                JSON.stringify(data)
            );

        }


        /*
        |--------------------------------------------------------------------------
        | RENDER SELECTED ASSET TABLE
        |--------------------------------------------------------------------------
        */

        function renderSelectedAssets() {

            selectedAssetTableBody.innerHTML =
                '';


            if (
                selectedAssets.size === 0
            ) {

                selectedAssetSummary.classList.add(
                    'd-none'
                );

                selectedAssetCount.textContent =
                    '0';

                return;

            }


            selectedAssetSummary.classList.remove(
                'd-none'
            );


            selectedAssetCount.textContent =
                selectedAssets.size;


            selectedAssets.forEach(
                function (
                    asset,
                    assetId
                ) {

                    const row =
                        document.createElement(
                            'tr'
                        );


                    row.innerHTML = `

                        <td>
                            ${escapeHtml(
                                asset.AssetID ?? assetId
                            )}
                        </td>

                        <td>
                            ${escapeHtml(
                                asset.AssetType ?? '-'
                            )}
                        </td>

                        <td>
                            ${escapeHtml(
                                asset.Brand ?? '-'
                            )}
                        </td>

                        <td>
                            ${escapeHtml(
                                asset.Model ?? '-'
                            )}
                        </td>

                        <td>
                            ${escapeHtml(
                                asset.SerialNo ?? '-'
                            )}
                        </td>

                        <td class="text-center">

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-danger remove-selected-asset"
                                data-asset-id="${escapeHtml(
                                    assetId
                                )}"
                                title="Remove"
                            >

                                <i class="bi bi-x-lg"></i>

                            </button>

                        </td>

                    `;


                    selectedAssetTableBody.appendChild(
                        row
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | ESCAPE HTML
        |--------------------------------------------------------------------------
        */

        function escapeHtml(value) {

            return String(value ?? '')
                .replace(
                    /&/g,
                    '&amp;'
                )
                .replace(
                    /</g,
                    '&lt;'
                )
                .replace(
                    />/g,
                    '&gt;'
                )
                .replace(
                    /"/g,
                    '&quot;'
                )
                .replace(
                    /'/g,
                    '&#039;'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | APPLY CHECKBOX STATE
        |--------------------------------------------------------------------------
        */

        function applyCheckboxState() {

            document
                .querySelectorAll(
                    '.asset-checkbox'
                )
                .forEach(
                    function (checkbox) {

                        checkbox.checked =
                            selectedAssets.has(
                                String(
                                    checkbox.value
                                )
                            );

                    }
                );

        }


        /*
        |--------------------------------------------------------------------------
        | CHECKBOX EVENT
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.asset-checkbox'
            )
            .forEach(
                function (checkbox) {

                    checkbox.addEventListener(
                        'change',
                        function () {

                            const assetId =
                                String(
                                    this.value
                                );


                            if (
                                this.checked
                            ) {

                                const asset =
                                    currentAssets.find(
                                        function (
                                            item
                                        ) {

                                            return String(
                                                item.AssetID
                                            ) === assetId;

                                        }
                                    );


                                if (asset) {

                                    selectedAssets.set(
                                        assetId,
                                        asset
                                    );

                                }

                            } else {

                                selectedAssets.delete(
                                    assetId
                                );

                            }


                            saveSelectedAssets();

                            renderSelectedAssets();

                        }
                    );

                }
            );


        /*
        |--------------------------------------------------------------------------
        | REMOVE SELECTED ASSET
        |--------------------------------------------------------------------------
        */

        selectedAssetTableBody.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest(
                        '.remove-selected-asset'
                    );


                if (!button) {
                    return;
                }


                const assetId =
                    String(
                        button.dataset.assetId
                    );


                selectedAssets.delete(
                    assetId
                );


                saveSelectedAssets();

                renderSelectedAssets();

                applyCheckboxState();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | REQUEST TYPE
        |--------------------------------------------------------------------------
        */

        function syncDateUntil() {

            if (
                requestType.value ===
                'Permanent'
            ) {

                dateUntil.readOnly =
                    true;

                dateUntil.value =
                    '1900-01-01';

            } else {

                dateUntil.readOnly =
                    false;


                if (
                    dateUntil.value ===
                    '1900-01-01'
                ) {

                    dateUntil.value =
                        '';

                }

            }

        }


        requestType.addEventListener(
            'change',
            syncDateUntil
        );


        syncDateUntil();


        /*
        |--------------------------------------------------------------------------
        | LOAD ASSET
        |--------------------------------------------------------------------------
        */

        loadAssetButton.addEventListener(
            'click',
            function () {

                const type =
                    assetType.value;


                if (!type) {

                    alert(
                        'Silakan pilih Asset Type terlebih dahulu.'
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | IMPORTANT
                |--------------------------------------------------------------------------
                |
                | selectedAssets TIDAK di-reset.
                |
                | Semua asset yang sudah dipilih tetap
                | tersimpan walaupun filter diganti.
                |
                */

                saveSelectedAssets();


                const url =
                    new URL(
                        "{{ route('employee-equipment.create') }}",
                        window.location.origin
                    );


                url.searchParams.set(
                    'AssetTypeID',
                    type
                );


                const searchInput =
                    document.querySelector(
                        '[name="asset_search"]'
                    );


                const search =
                    searchInput.value.trim();


                if (search) {

                    url.searchParams.set(
                        'asset_search',
                        search
                    );

                }


                window.location.href =
                    url.toString();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | FORM SUBMIT
        |--------------------------------------------------------------------------
        |
        | Generate AssetID[] dari SEMUA selectedAssets.
        |
        | Jadi asset yang sedang tidak tampil karena filter
        | tetap ikut dikirim ke backend.
        |
        */

        form.addEventListener(
            'submit',
            function () {


                /*
                |--------------------------------------------------------------------------
                | Remove old hidden inputs
                |--------------------------------------------------------------------------
                */

                form
                    .querySelectorAll(
                        '.asset-submit-hidden'
                    )
                    .forEach(
                        function (input) {

                            input.remove();

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | Create hidden AssetID[]
                |--------------------------------------------------------------------------
                */

                selectedAssets.forEach(
                    function (
                        asset,
                        assetId
                    ) {

                        const input =
                            document.createElement(
                                'input'
                            );


                        input.type =
                            'hidden';


                        input.name =
                            'AssetID[]';


                        input.value =
                            assetId;


                        input.classList.add(
                            'asset-submit-hidden'
                        );


                        form.appendChild(
                            input
                        );

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Clear browser state
                |--------------------------------------------------------------------------
                */

                sessionStorage.removeItem(
                    storageKey
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL RENDER
        |--------------------------------------------------------------------------
        */

        renderSelectedAssets();

        applyCheckboxState();

    }
);

</script>

@endpush

@endsection