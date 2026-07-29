<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\BaseController;
use App\Services\Master\CompanyService;
use App\Http\Requests\Master\CompanyRequest;
use App\Models\Master\MsCompany;

class CompanyController extends BaseController
{
    public function __construct(
        protected CompanyService $service
    ) {
    }

    public function index()
    {
        return view('master.company.index', [
            'companies' => $this->service->getAll(),
        ]);
    }

    public function create()
    {
        return view('master.company.create');
    }

    public function store(CompanyRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company berhasil ditambahkan.');
    }

    public function edit(MsCompany $company)
    {
        return view('master.company.edit', compact('company'));
    }

    public function update(
        CompanyRequest $request,
        MsCompany $company
    ) {
        $this->service->update(
            $company,
            $request->validated()
        );

        return redirect()
            ->route('companies.index')
            ->with('success', 'Company berhasil diperbarui.');
    }
}
