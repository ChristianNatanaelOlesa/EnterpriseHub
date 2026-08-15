<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCompanyRequest;
use App\Http\Requests\Master\UpdateCompanyRequest;
use App\Services\Master\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request)
    {
        $companies = $this->companyService->getAll(
            $request->input('search')
        );

        return view(
            'master.company.index',
            compact('companies')
        );
    }

    public function create()
    {
        return view('master.company.create');
    }

    public function store(StoreCompanyRequest $request)
    {
        $this->companyService->store(
            $request->validated()
        );

        return redirect()
            ->route('master.company.index')
            ->with('success', 'Company berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $company = $this->companyService->findById((int) $id);

        return view(
            'master.company.show',
            compact('company')
        );
    }

    public function edit(string $id)
    {
        $company = $this->companyService->findById(
            (int) $id
        );

        return view(
            'master.company.edit',
            compact('company')
        );
    }

    public function update(
        UpdateCompanyRequest $request,
        string $id
    ) {
        $this->companyService->update(
            (int) $id,
            $request->validated()
        );

        return redirect()
            ->route('master.company.index')
            ->with('success', 'Company berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $this->companyService->delete((int) $id);

        return redirect()
            ->route('master.company.index')
            ->with('success', 'Company berhasil dinonaktifkan.');
    }
}
