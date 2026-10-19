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
            ->orderBy('Company')
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
            $id
        );

        return view(
            'master.department.show',
            compact('department')
        );
    }

    public function edit(string $id)
    {
        $department = $this->departmentService->findById(
            $id
        );

        $companies = MsCompany::query()
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('Company')
            ->get();

        $directorates = MsDirectorate::query()
            ->where(
                'CompID',
                $department->CompID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('Directorate')
            ->get();

        $divisions = MsDivision::query()
            ->where(
                'DirID',
                $department->DirID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('Division')
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
            $id,
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
            $id
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
            'CompID' => [
                'required',
                'string',
                'max:3',
                'exists:ms_company,CompID',
            ],
        ]);

        return MsDirectorate::query()
            ->where(
                'CompID',
                $request->CompID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('Directorate')
            ->get([
                'DirID',
                'Directorate',
            ]);
    }

    public function getDivisions(Request $request)
    {
        $request->validate([
            'DirID' => [
                'required',
                'string',
                'max:3',
                'exists:ms_directorate,DirID',
            ],
        ]);

        return MsDivision::query()
            ->where(
                'DirID',
                $request->DirID
            )
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('Division')
            ->get([
                'DivID',
                'Division',
            ]);
    }
}
