<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpAppRequest;
use App\Http\Requests\EForm\UpdateEmpAppRequest;
use App\Services\EForm\EmpAppService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmpAppController extends Controller
{
    public function __construct(
        protected EmpAppService $service
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $employeeApps = $this->service->getAll(
            $search,
            (int) $request->input('perPage', 10)
        );

        return view(
            'eform.employee-app.index',
            compact('employeeApps', 'search')
        );
    }

    public function create(): View
    {
        $empForm = $this->service->currentEmployeeForm();

        return view(
            'eform.employee-app.create',
            compact('empForm') + ['mode' => 'create']
        );
    }

    public function store(StoreEmpAppRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('employee-app.index')
            ->with('success', 'Employee Application berhasil dibuat.');
    }

    public function edit(string $employeeApp): View
    {
        $employeeApp = $this->service->find($employeeApp);

        abort_if(!$employeeApp, 404);

        return view(
            'eform.employee-app.edit',
            compact('employeeApp') + ['mode' => 'edit']
        );
    }

    public function update(
        UpdateEmpAppRequest $request,
        string $employeeApp
    ): RedirectResponse {
        $this->service->update(
            $employeeApp,
            $request->validated()
        );

        return redirect()
            ->route('employee-app.index')
            ->with('success', 'Employee Application berhasil diupdate.');
    }

    public function destroy(string $employeeApp): RedirectResponse
    {
        $this->service->delete($employeeApp);

        return redirect()
            ->route('employee-app.index')
            ->with('success', 'Employee Application berhasil dihapus.');
    }
}
