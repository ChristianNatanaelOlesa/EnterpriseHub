<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreJobTitleRequest;
use App\Http\Requests\Master\UpdateJobTitleRequest;
use App\Services\Master\JobTitleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobTitleController extends Controller
{
    public function __construct(protected JobTitleService $service) {}

    public function index(Request $request): View
    {
        $jobTitles = $this->service->getAll($request->input('search'), (int) $request->input('perPage', 10));
        return view('master.job-title.index', compact('jobTitles'));
    }

    public function create(): View
    {
        return view('master.job-title.create');
    }

    public function store(StoreJobTitleRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());
        return redirect()->route('master.job-title.index')->with('success', 'Job Title created successfully.');
    }

    public function edit(string $jobTitle): View
    {
        $data = $this->service->find($jobTitle);
        abort_if(!$data, 404);
        return view('master.job-title.edit', compact('data'));
    }

    public function update(UpdateJobTitleRequest $request, string $jobTitle): RedirectResponse
    {
        $this->service->update($jobTitle, $request->validated());
        return redirect()->route('master.job-title.index')->with('success', 'Job Title updated successfully.');
    }

    public function destroy(string $jobTitle): RedirectResponse
    {
        $this->service->delete($jobTitle);
        return redirect()->route('master.job-title.index')->with('success', 'Job Title deleted successfully.');
    }
}
