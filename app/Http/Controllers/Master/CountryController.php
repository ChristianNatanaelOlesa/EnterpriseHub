<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCountryRequest;
use App\Http\Requests\Master\UpdateCountryRequest;
use App\Services\Master\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $countries = $this->countryService->getAll(
            $request->input('search')
        );

        return view(
            'master.country.index',
            compact('countries')
        );
    }

    public function create()
    {
        return view('master.country.create');
    }

    public function store(StoreCountryRequest $request)
    {
        $this->countryService->store(
            $request->validated()
        );

        return redirect()
            ->route('master.country.index')
            ->with('success', 'Country berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $country = $this->countryService->findById($id);

        return view(
            'master.country.show',
            compact('country')
        );
    }

    public function edit(string $id)
    {
        $country = $this->countryService->findById($id);

        return view(
            'master.country.edit',
            compact('country')
        );
    }

    public function update(
        UpdateCountryRequest $request,
        string $id
    ) {
        $this->countryService->update(
            $id,
            $request->validated()
        );

        return redirect()
            ->route('master.country.index')
            ->with('success', 'Country berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $this->countryService->delete($id);

        return redirect()
            ->route('master.country.index')
            ->with('success', 'Country berhasil dinonaktifkan.');
    }
}
