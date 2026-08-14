<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Master\CompanyService;
use App\Models\Master\MsCompany;
use App\Http\Requests\Master\CompanyRequest;

class CompanyController extends BaseController
{
    private CompanyService $service;

    public function __construct(CompanyService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $companies = MsCompany::query()

            ->when(
                $request->search,
                function ($query) use ($request) {

                    $query->where(
                        'CompanyCode',
                        'like',
                        "%{$request->search}%"
                    )

                    ->orWhere(
                        'CompanyName',
                        'like',
                        "%{$request->search}%"
                    );

                }
            )

            ->where('IsActive', 1)

            ->orderBy('CompanyCode')

            ->paginate(10)

            ->withQueryString();

        return view(
            'master.company.index',
            compact('companies')
        );
    }

    public function create()
    {
        return view(
            'master.company.create'
        );
    }

    public function store(
        CompanyRequest $request
    ) {
        $data = $request->validated();

        $data['CreatedBy'] = auth()->user()->Username;

        $data['CreatedDate'] = now();

        MsCompany::create($data);

        return redirect()

            ->route('master.company.index')

            ->with(
                'success',
                'Company berhasil ditambahkan.'
            );
    }

    public function edit($id)
    {
        $company = MsCompany::findOrFail($id);

        return view(
            'master.company.edit',
            compact('company')
        );
    }

    public function update(
        CompanyRequest $request,
        $id
    ) {
        $company = MsCompany::findOrFail($id);

        $data = $request->validated();

        $data['UpdatedBy'] = auth()->user()->Username;

        $data['UpdatedDate'] = now();

        $company->update($data);

        return redirect()

            ->route('master.company.index')

            ->with(
                'success',
                'Company berhasil diubah.'
            );
    }

    public function destroy($id)
    {
        $company = MsCompany::findOrFail($id);

        $company->update([

            'IsActive' => 0,

            'DeletedBy' => auth()->user()->Username,

            'DeletedDate' => now()

        ]);

        return redirect()

            ->route('master.company.index')

            ->with(
                'success',
                'Company berhasil dinonaktifkan.'
            );
    }
}
