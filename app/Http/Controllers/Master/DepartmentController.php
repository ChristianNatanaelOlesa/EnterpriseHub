<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreDepartmentRequest;
use App\Http\Requests\Master\UpdateDepartmentRequest;
use App\Models\Master\MsCompany;
use App\Models\Master\MsDirectorate;
use App\Models\Master\MsDivision;
use App\Services\Master\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        $departments = $this->departmentService->getAll(
            $request->input('search')
        );

        return view(
            'master.department.index',
            compact('departments')
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

        $divisions = collect();

        return view(
            'master.department.create',
            compact(
                'companies',
                'directorates',
                'divisions'
            )
        );
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentService->store(
            $request->validated()
        );

        return redirect()
            ->route('master.department.index')
            ->with(
                'success',
                'Department berhasil ditambahkan.'
            );
    }

    public function show(string $id)
    {
        $department = $this->departmentService->findById(
            (int) $id
        );

        return view(
            'master.department.show',
            compact('department')
        );
    }

    public function edit(string $id)
    {
        $department = $this->departmentService->findById(
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
                $department->CompanyID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('DirectorateName')
            ->get();

        $divisions = MsDivision::query()
            ->where(
                'DirectorateID',
                $department->DirectorateID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('DivisionName')
            ->get();

        return view(
            'master.department.edit',
            compact(
                'department',
                'companies',
                'directorates',
                'divisions'
            )
        );
    }

    public function update(
        UpdateDepartmentRequest $request,
        string $id
    ) {
        $this->departmentService->update(
            (int) $id,
            $request->validated()
        );

        return redirect()
            ->route('master.department.index')
            ->with(
                'success',
                'Department berhasil diupdate.'
            );
    }

    public function destroy(string $id)
    {
        $this->departmentService->delete(
            (int) $id
        );

        return redirect()
            ->route('master.department.index')
            ->with(
                'success',
                'Department berhasil dinonaktifkan.'
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
            ->where(
                'CompanyID',
                $request->CompanyID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('DirectorateName')
            ->get([
                'DirectorateID',
                'DirectorateName',
            ]);
    }

    public function getDivisions(Request $request)
    {
        $request->validate([
            'DirectorateID' => [
                'required',
                'integer',
                'exists:ms_directorate,DirectorateID',
            ],
        ]);

        return MsDivision::query()
            ->where(
                'DirectorateID',
                $request->DirectorateID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('DivisionName')
            ->get([
                'DivisionID',
                'DivisionName',
            ]);
    }
}
