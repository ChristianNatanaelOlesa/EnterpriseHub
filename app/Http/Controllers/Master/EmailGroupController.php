<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreEmailGroupRequest;
use App\Http\Requests\Master\UpdateEmailGroupRequest;
use App\Services\Master\EmailGroupService;
use App\Models\Master\MsDivision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailGroupController extends Controller
{
    public function __construct(
        protected EmailGroupService $service
    ) {
    }

    public function index(Request $request): View
    {
        $emailGroups = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view('master.email-group.index', compact('emailGroups'));
    }

    public function create(): View
    {
        $divisions = MsDivision::query()
            ->whereNull('DeletedDate')
            ->where('IsActive', true)
            ->orderBy('DivisionName')
            ->get(['DivisionID', 'DivisionName']);

        return view('master.email-group.create', compact('divisions'));
    }

    public function store(StoreEmailGroupRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('master.email-group.index')
            ->with('success', 'Email Group berhasil ditambahkan.');
    }

    public function show(string $emailGroup): RedirectResponse
    {
        return redirect()->route('master.email-group.edit', $emailGroup);
    }

    public function edit(string $emailGroup): View
    {
        $data = $this->service->findById($emailGroup);

        $divisions = MsDivision::query()
            ->whereNull('DeletedDate')
            ->where('IsActive', true)
            ->orderBy('DivisionName')
            ->get(['DivisionID', 'DivisionName']);

        return view('master.email-group.edit', compact('data', 'divisions'));
    }

    public function update(
        UpdateEmailGroupRequest $request,
        string $emailGroup
    ): RedirectResponse {
        $this->service->update(
            $emailGroup,
            $request->validated()
        );

        return redirect()
            ->route('master.email-group.index')
            ->with('success', 'Email Group berhasil diupdate.');
    }

    public function destroy(string $emailGroup): RedirectResponse
    {
        $this->service->delete($emailGroup);

        return redirect()
            ->route('master.email-group.index')
            ->with('success', 'Email Group berhasil dinonaktifkan.');
    }
}
