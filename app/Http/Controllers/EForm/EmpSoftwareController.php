<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpSoftwareRequest;
use App\Http\Requests\EForm\UpdateEmpSoftwareRequest;
use App\Models\EForm\TrEmpFormHist;
use App\Models\Master\MsDivision;
use App\Services\EForm\EmpSoftwareService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmpSoftwareController extends Controller
{
    public function __construct(
        protected EmpSoftwareService $service
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view(
            'eform.employee-software.index',
            compact('data')
        );
    }

    public function create(): View
    {
        $user = auth()->user();
        $empFormID = $user?->EmpFormID;
        $reqUser = $user?->Username ?? $user?->username ?? $user?->email ?? 'Admin';

        $history = null;

        if ($empFormID) {
            $history = TrEmpFormHist::query()
                ->where('EmpFormID', $empFormID)
                ->orderByDesc('InputDate')
                ->first();
        }

        $reqDivID = $history?->DivID;
        $division = $reqDivID
            ? MsDivision::find($reqDivID)
            : null;

        return view(
            'eform.employee-software.create',
            compact(
                'empFormID',
                'reqDivID',
                'reqUser',
                'division'
            )
        );
    }

    public function store(StoreEmpSoftwareRequest $request): RedirectResponse
    {
        $this->service->createForUser(
            $request->validated()
        );

        return redirect()
            ->route('employee-software.index')
            ->with(
                'success',
                'Employee Software created successfully.'
            );
    }

    public function edit(string $EmpSoftwareID): View
    {
        $data = $this->service->find($EmpSoftwareID);

        abort_if(!$data, 404);

        $division = $data->ReqDivID
            ? MsDivision::find($data->ReqDivID)
            : null;

        return view(
            'eform.employee-software.edit',
            compact('data', 'division')
        );
    }

    public function update(
        UpdateEmpSoftwareRequest $request,
        string $EmpSoftwareID
    ): RedirectResponse {
        $this->service->update(
            $EmpSoftwareID,
            $request->validated()
        );

        return redirect()
            ->route('employee-software.index')
            ->with(
                'success',
                'Employee Software updated successfully.'
            );
    }

    public function destroy(string $EmpSoftwareID): RedirectResponse
    {
        $this->service->delete($EmpSoftwareID);

        return redirect()
            ->route('employee-software.index')
            ->with(
                'success',
                'Employee Software deleted successfully.'
            );
    }
}
