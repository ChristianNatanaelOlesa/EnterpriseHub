<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreDirectorateRequest;
use App\Http\Requests\Master\UpdateDirectorateRequest;
use App\Models\Master\MsCompany;
use App\Services\Master\DirectorateService;
use Illuminate\Http\Request;

class DirectorateController extends Controller
{
    protected DirectorateService $directorateService;

    public function __construct(DirectorateService $directorateService)
    {
        $this->directorateService = $directorateService;
    }

    public function index(Request $request)
    {
        $directorates = $this->directorateService->getAll(
            $request->input('search')
        );

        return view(
            'master.directorate.index',
            compact('directorates')
        );
    }

    public function create()
    {
        $companies = MsCompany::query()
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('CompanyName')
            ->get();

        return view(
            'master.directorate.create',
            compact('companies')
        );
    }

    public function store(StoreDirectorateRequest $request)
    {
        $this->directorateService->store(
            $request->validated()
        );

        return redirect()
            ->route('master.directorate.index')
            ->with(
                'success',
                'Directorate berhasil ditambahkan.'
            );
    }

    public function show(string $id)
    {
        $directorate = $this->directorateService->findById(
            (int) $id
        );

        return view(
            'master.directorate.show',
            compact('directorate')
        );
    }

    public function edit(string $id)
    {
        $directorate = $this->directorateService->findById(
            (int) $id
        );

        $companies = MsCompany::query()
            ->where('IsActive', true)
            ->whereNull('DeletedDate')
            ->orderBy('CompanyName')
            ->get();

        return view(
            'master.directorate.edit',
            compact(
                'directorate',
                'companies'
            )
        );
    }

    public function update(
        UpdateDirectorateRequest $request,
        string $id
    ) {
        $this->directorateService->update(
            (int) $id,
            $request->validated()
        );

        return redirect()
            ->route('master.directorate.index')
            ->with(
                'success',
                'Directorate berhasil diupdate.'
            );
    }

    public function destroy(string $id)
    {
        $this->directorateService->delete(
            (int) $id
        );

        return redirect()
            ->route('master.directorate.index')
            ->with(
                'success',
                'Directorate berhasil dinonaktifkan.'
            );
    }
}
