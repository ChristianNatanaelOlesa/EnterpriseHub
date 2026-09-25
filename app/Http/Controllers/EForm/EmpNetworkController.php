<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpNetworkRequest;
use App\Http\Requests\EForm\UpdateEmpNetworkRequest;
use App\Services\EForm\EmpNetworkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmpNetworkController extends Controller
{
    public function __construct(
        protected EmpNetworkService $service
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view(
            'eform.employee-network.index',
            compact('data')
        );
    }

    public function create(): View
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Employee Form ID
        |--------------------------------------------------------------------------
        */
        $empFormID = $user?->EmpFormID;

        /*
        |--------------------------------------------------------------------------
        | Get Employee Division
        |--------------------------------------------------------------------------
        |
        | Tr_EmpFormHist.DivID
        |          ↓
        | Ms_Division.DivisionID
        |
        |--------------------------------------------------------------------------
        */
        $employeeHistory = null;

        if ($empFormID) {

            $employeeHistory = DB::table('tr_empformhist as efh')
                ->leftJoin(
                    'ms_division as div',
                    'efh.DivID',
                    '=',
                    'div.DivisionID'
                )
                ->where(
                    'efh.EmpFormID',
                    $empFormID
                )
                ->orderByDesc('efh.EffectiveDate')
                ->orderByDesc('efh.InputDate')
                ->select([
                    'efh.DivID as ReqDivID',
                    'div.DivisionID',
                    'div.DivisionCode',
                    'div.DivisionName',
                ])
                ->first();
        }

        $reqDivID = $employeeHistory?->ReqDivID;

        $division = $employeeHistory;

        return view(
            'eform.employee-network.create',
            [
                'empFormID' => $empFormID,
                'reqDivID'  => $reqDivID,
                'division'  => $division,
            ]
        );
    }

    public function store(
        StoreEmpNetworkRequest $request
    ): RedirectResponse {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('employee-network.index')
            ->with(
                'success',
                'Employee Network created successfully.'
            );
    }

    public function edit(
        string $EmpNetworkID
    ): View {
        $data = $this->service->find(
            $EmpNetworkID
        );

        abort_if(!$data, 404);

        /*
        |--------------------------------------------------------------------------
        | Get Division
        |--------------------------------------------------------------------------
        |
        | Employee Network
        |      ↓
        | ReqDivID
        |      ↓
        | Ms_Division.DivisionID
        |
        |--------------------------------------------------------------------------
        */
        $division = null;

        if ($data->ReqDivID) {

            $division = DB::table('ms_division')
                ->where(
                    'DivisionID',
                    $data->ReqDivID
                )
                ->select([
                    'DivisionID',
                    'DivisionCode',
                    'DivisionName',
                ])
                ->first();
        }

        return view(
            'eform.employee-network.edit',
            [
                'data'     => $data,
                'division' => $division,
            ]
        );
    }

    public function update(
        UpdateEmpNetworkRequest $request,
        string $EmpNetworkID
    ): RedirectResponse {
        $this->service->update(
            $EmpNetworkID,
            $request->validated()
        );

        return redirect()
            ->route('employee-network.index')
            ->with(
                'success',
                'Employee Network updated successfully.'
            );
    }

    public function destroy(
        string $EmpNetworkID
    ): RedirectResponse {
        $this->service->delete(
            $EmpNetworkID
        );

        return redirect()
            ->route('employee-network.index')
            ->with(
                'success',
                'Employee Network deleted successfully.'
            );
    }
}
