<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpITAreaRequest;
use App\Http\Requests\EForm\UpdateEmpITAreaRequest;
use App\Models\EForm\TrEmpFormHist;
use App\Services\EForm\EmpITAreaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmpITAreaController extends Controller
{
    public function __construct(
        protected EmpITAreaService $service
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view(
            'eform.employee-it-area.index',
            compact('data')
        );
    }

    public function create(): View
    {
        $user = auth()->user();

        $empFormID = $user?->EmpFormID;
        $reqUser = $user?->Username
            ?? $user?->username
            ?? $user?->email
            ?? '-';

        $history = null;

        if ($empFormID) {
            $history = TrEmpFormHist::query()
                ->with('division')
                ->where('EmpFormID', $empFormID)
                ->orderByDesc('EffectiveDate')
                ->orderByDesc('InputDate')
                ->first();
        }

        return view(
            'eform.employee-it-area.create',
            [
                'empFormID' => $empFormID,
                'reqDivID' => $history?->DivID,
                'reqUser' => $reqUser,
                'division' => $history?->division,
            ]
        );
    }

    public function store(
        StoreEmpITAreaRequest $request
    ): RedirectResponse {
        $user = auth()->user();

        $history = null;

        if ($user?->EmpFormID) {
            $history = TrEmpFormHist::query()
                ->where('EmpFormID', $user->EmpFormID)
                ->orderByDesc('EffectiveDate')
                ->orderByDesc('InputDate')
                ->first();
        }

        $payload = $request->validated();

        $payload['EmpFormID'] = $user?->EmpFormID;
        $payload['ReqDivID'] = $history?->DivID;
        $payload['ReqUser'] = $user?->Username
            ?? $user?->username
            ?? $user?->email
            ?? 'Admin';
        $payload['ReqDate'] = now()->toDateString();

        $payload['DataCenter'] = $request->boolean('DataCenter');
        $payload['FingerPrint'] = $request->boolean('FingerPrint');
        $payload['Firewall'] = $request->boolean('Firewall');
        $payload['CCTV'] = $request->boolean('CCTV');
        $payload['ExtDrive'] = $request->boolean('ExtDrive');

        $this->service->create($payload);

        return redirect()
            ->route('employee-it-area.index')
            ->with(
                'success',
                'Employee IT Area created successfully.'
            );
    }

    public function edit(
        string $employeeITArea
    ): View {
        $data = $this->service->find($employeeITArea);

        abort_if(!$data, 404);

        return view(
            'eform.employee-it-area.edit',
            compact('data')
        );
    }

    public function update(
        UpdateEmpITAreaRequest $request,
        string $employeeITArea
    ): RedirectResponse {
        $payload = $request->validated();

        $payload['DataCenter'] = $request->boolean('DataCenter');
        $payload['FingerPrint'] = $request->boolean('FingerPrint');
        $payload['Firewall'] = $request->boolean('Firewall');
        $payload['CCTV'] = $request->boolean('CCTV');
        $payload['ExtDrive'] = $request->boolean('ExtDrive');

        $this->service->update(
            $employeeITArea,
            $payload
        );

        return redirect()
            ->route('employee-it-area.index')
            ->with(
                'success',
                'Employee IT Area updated successfully.'
            );
    }

    public function destroy(
        string $employeeITArea
    ): RedirectResponse {
        $this->service->delete($employeeITArea);

        return redirect()
            ->route('employee-it-area.index')
            ->with(
                'success',
                'Employee IT Area deleted successfully.'
            );
    }
}
