<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreReligionRequest;
use App\Http\Requests\Master\UpdateReligionRequest;
use App\Services\Master\ReligionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReligionController extends Controller
{
    public function __construct(
        protected ReligionService $service
    ) {
    }

    public function index(Request $request): View
    {
        $religions = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view('master.religion.index', compact('religions'));
    }

    public function create(): View
    {
        return view('master.religion.create');
    }

    public function store(
        StoreReligionRequest $request
    ): RedirectResponse {
        $this->service->create($request->validated());

        return redirect()
            ->route('master.religion.index')
            ->with('success', 'Religion created successfully.');
    }

    public function edit(string $religion): View
    {
        $data = $this->service->find($religion);

        abort_if(!$data, 404);

        return view('master.religion.edit', compact('data'));
    }

    public function update(
        UpdateReligionRequest $request,
        string $religion
    ): RedirectResponse {
        $this->service->update(
            $religion,
            $request->validated()
        );

        return redirect()
            ->route('master.religion.index')
            ->with('success', 'Religion updated successfully.');
    }

    public function destroy(string $religion): RedirectResponse
    {
        $this->service->delete($religion);

        return redirect()
            ->route('master.religion.index')
            ->with('success', 'Religion deleted successfully.');
    }
}
