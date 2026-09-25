<?php

namespace App\Http\Controllers\EForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpSharingFolderRequest;
use App\Http\Requests\EForm\UpdateEmpSharingFolderRequest;
use App\Models\EForm\TrEmpFormHist;
use App\Models\Master\MsDivision;
use App\Models\Master\MsFolderPath;
use App\Services\EForm\EmpSharingFolderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmpSharingFolderController extends Controller
{
    public function __construct(
        protected EmpSharingFolderService $service
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view(
            'eform.employee-sharing-folder.index',
            compact('data')
        );
    }

    public function create(): View
    {
        $user = auth()->user();
        $empFormID = $user?->EmpFormID;

        $reqDivID = null;

        if ($empFormID) {
            $history = TrEmpFormHist::where('EmpFormID', $empFormID)
                ->orderByDesc('InputDate')
                ->first();

            $reqDivID = $history?->ReqDivID ?? $history?->DivID;
        }

        $division = $reqDivID
            ? MsDivision::find($reqDivID)
            : null;

        return view('eform.employee-sharing-folder.create', [
            'empFormID' => $empFormID,
            'reqDivID' => $reqDivID,
            'reqUser' => $user?->Username ?? $user?->username ?? 'Admin',
            'division' => $division,
            'folders' => MsFolderPath::where('IsActive', true)
                ->orderBy('FolderName')
                ->get(),
        ]);
    }

    public function store(StoreEmpSharingFolderRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $payload = $request->validated();

        $payload['EmpFormID'] = $user?->EmpFormID;
        $payload['ReqUser'] = $user?->Username ?? $user?->username ?? 'Admin';
        $payload['ReqDate'] = now()->toDateString();

        $history = TrEmpFormHist::where('EmpFormID', $payload['EmpFormID'])
            ->orderByDesc('InputDate')
            ->first();

        $payload['ReqDivID'] = $history?->ReqDivID ?? $history?->DivID;

        $this->service->create($payload);

        return redirect()
            ->route('employee-sharing-folder.index')
            ->with('success', 'Employee Sharing Folder created successfully.');
    }

    public function edit(string $employeeSharingFolder): View
    {
        $data = $this->service->find($employeeSharingFolder);

        abort_if(!$data, 404);

        $selectedFolderIds = $data->details
            ->whereNotNull('FolderPathID')
            ->pluck('FolderPathID')
            ->values()
            ->all();

        $existingAccessType = $data->details->first()?->AccessType ?? 'Read';

        $newDetail = $data->details->firstWhere('FolderPathID', null);

        return view('eform.employee-sharing-folder.edit', [
            'data' => $data,
            'folders' => MsFolderPath::where('IsActive', true)
                ->orderBy('FolderName')
                ->get(),
            'selectedFolderIds' => $selectedFolderIds,
            'existingAccessType' => $existingAccessType,
            'selectedParentFolderId' => $newDetail?->ParentFolderPathID,
            'newFolderName' => $newDetail?->FolderName,
        ]);
    }

    public function update(
        UpdateEmpSharingFolderRequest $request,
        string $employeeSharingFolder
    ): RedirectResponse {
        $this->service->update(
            $employeeSharingFolder,
            $request->validated()
        );

        return redirect()
            ->route('employee-sharing-folder.index')
            ->with('success', 'Employee Sharing Folder updated successfully.');
    }

    public function destroy(string $employeeSharingFolder): RedirectResponse
    {
        $this->service->delete($employeeSharingFolder);

        return redirect()
            ->route('employee-sharing-folder.index')
            ->with('success', 'Employee Sharing Folder deleted successfully.');
    }
}
