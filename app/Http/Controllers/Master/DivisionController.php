<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreDivisionRequest;
use App\Http\Requests\Master\UpdateDivisionRequest;
use App\Models\Master\MsCompany;
use App\Models\Master\MsDirectorate;
use App\Services\Master\DivisionService;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    protected DivisionService $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->divisionService = $divisionService;
    }

    public function index(Request $request)
    {
        $divisions = $this->divisionService->getAll(
            $request->input('search')
        );

        return view(
            'master.division.index',
            compact('divisions')
        );
    }

    public function create()
    {
        $companies = MsCompany::query()
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('CompanyName')
            ->get();

        $directorates = collect();

        return view(
            'master.division.create',
            compact(
                'companies',
                'directorates'
            )
        );
    }

    public function store(StoreDivisionRequest $request)
    {
        $this->divisionService->store(
            $request->validated()
        );

        return redirect()
            ->route('master.division.index')
            ->with(
                'success',
                'Division berhasil ditambahkan.'
            );
    }

    public function show(string $id)
    {
        $division = $this->divisionService->findById(
            (int) $id
        );

        return view(
            'master.division.show',
            compact('division')
        );
    }

    public function edit(string $id)
    {
        $division = $this->divisionService->findById(
            (int) $id
        );

        $companies = MsCompany::query()
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('CompanyName')
            ->get();

        $directorates = MsDirectorate::query()
            ->where(
                'CompanyID',
                $division->directorate?->CompanyID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('DirectorateName')
            ->get();

        return view(
            'master.division.edit',
            compact(
                'division',
                'companies',
                'directorates'
            )
        );
    }

    public function update(
        UpdateDivisionRequest $request,
        string $id
    ) {
        $this->divisionService->update(
            (int) $id,
            $request->validated()
        );

        return redirect()
            ->route('master.division.index')
            ->with(
                'success',
                'Division berhasil diupdate.'
            );
    }

    public function destroy(string $id)
    {
        $this->divisionService->delete(
            (int) $id
        );

        return redirect()
            ->route('master.division.index')
            ->with(
                'success',
                'Division berhasil dinonaktifkan.'
            );
    }

    public function getDirectorates(Request $request)
    {
        $request->validate([
            'CompanyID' => [
                'required',
                'integer',
                'exists:ms_company,CompanyID',
            ],
        ]);

        return MsDirectorate::query()
            ->where('CompanyID', $request->CompanyID)
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('DirectorateName')
            ->get([
                'DirectorateID',
                'DirectorateName',
            ]);
    }
}
