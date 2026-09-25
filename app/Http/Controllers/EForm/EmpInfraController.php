<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpInfraRequest;
use App\Http\Requests\EForm\UpdateEmpInfraRequest;
use App\Models\EForm\TrEmpFormHist;
use App\Models\Master\MsDivision;
use App\Services\EForm\EmpInfraService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EmpInfraController extends Controller
{
    public function __construct(
        protected EmpInfraService $service
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view(
            'eform.employee-infra.index',
            compact('data')
        );
    }

    public function create(): View
    {
        $context = $this->employeeContext();

        return view(
            'eform.employee-infra.create',
            $context
        );
    }

    public function store(
        StoreEmpInfraRequest $request
    ): RedirectResponse {
        $context = $this->employeeContext();

        if (!$context['empFormID']) {
            throw ValidationException::withMessages([
                'EmpFormID' => 'User login belum memiliki EmpFormID.',
            ]);
        }

        $payload = array_merge(
            $request->validated(),
            [
                'EmpFormID' => $context['empFormID'],
                'ReqDivID' => $context['reqDivID'],
                'ReqUser' => $context['reqUser'],
                'ReqDate' => now()->toDateString(),
            ]
        );

        $this->service->create($payload);

        return redirect()
            ->route('employee-infra.index')
            ->with(
                'success',
                'Employee Infrastructure created successfully.'
            );
    }

    public function edit(string $EmpInfraID): View
    {
        $data = $this->service->find($EmpInfraID);

        abort_if(!$data, 404);

        return view(
            'eform.employee-infra.edit',
            [
                'data' => $data,
                'division' => $data->division,
            ]
        );
    }

    public function update(
        UpdateEmpInfraRequest $request,
        string $EmpInfraID
    ): RedirectResponse {
        $this->service->update(
            $EmpInfraID,
            $request->validated()
        );

        return redirect()
            ->route('employee-infra.index')
            ->with(
                'success',
                'Employee Infrastructure updated successfully.'
            );
    }

    public function destroy(string $EmpInfraID): RedirectResponse
    {
        $this->service->delete($EmpInfraID);

        return redirect()
            ->route('employee-infra.index')
            ->with(
                'success',
                'Employee Infrastructure deleted successfully.'
            );
    }

    private function employeeContext(): array
    {
        $user = auth()->user();

        $empFormID = $user?->EmpFormID;

        $reqDivID = null;
        $division = null;

        if ($empFormID) {
            $history = TrEmpFormHist::query()
                ->where('EmpFormID', $empFormID)
                ->orderByDesc('InputDate')
                ->first();

            $reqDivID = $history?->DivID;

            if ($reqDivID) {
                $division = MsDivision::find($reqDivID);
            }
        }

        return [
            'empFormID' => $empFormID,
            'reqDivID' => $reqDivID,
            'division' => $division,
            'reqUser' => $user?->Username
                ?? $user?->username
                ?? $user?->email
                ?? 'Admin',
        ];
    }
}
