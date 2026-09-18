<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreProvinceRequest;
use App\Http\Requests\Master\UpdateProvinceRequest;
use App\Models\Master\MsCountry;
use App\Models\Master\MsProvince;
use App\Services\Master\ProvinceService;

class ProvinceController extends Controller
{
    protected ProvinceService $service;

    public function __construct(ProvinceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $provinces = $this->service->search(
            request('search'),
            10
        );

        return view(
            'master.province.index',
            compact('provinces')
        );
    }

    public function create()
    {
        $countries = MsCountry::where('IsActive', true)
            ->orderBy('Country')
            ->get();

        return view('master.province.create', compact('countries'));
    }

    public function store(StoreProvinceRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('master.province.index')
            ->with('success', 'Province berhasil ditambahkan.');
    }

    public function edit(MsProvince $province)
    {
        $countries = MsCountry::where('IsActive', true)
            ->orderBy('Country')
            ->get();

        return view(
            'master.province.edit',
            compact('province', 'countries')
        );
    }

    public function update(
        UpdateProvinceRequest $request,
        MsProvince $province
    ) {
        $this->service->update(
            $province,
            $request->validated()
        );

        return redirect()
            ->route('master.province.index')
            ->with('success', 'Province berhasil diperbarui.');
    }

    public function destroy(MsProvince $province)
    {
        $this->service->delete($province);

        return redirect()
            ->route('master.province.index')
            ->with('success', 'Province berhasil dihapus.');
    }
}
