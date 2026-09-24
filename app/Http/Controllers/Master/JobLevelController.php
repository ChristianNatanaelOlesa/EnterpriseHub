<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreJobLevelRequest;
use App\Http\Requests\Master\UpdateJobLevelRequest;
use App\Services\Master\JobLevelService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobLevelController extends Controller
{
    public function __construct(protected JobLevelService $service) {}

    public function index(Request $request): View
    {
        $jobLevels = $this->service->getAll($request->input('search'), (int) $request->input('perPage', 10));
        return view('master.job-level.index', compact('jobLevels'));
    }

    public function create(): View
    {
        return view('master.job-level.create');
    }

    public function store(StoreJobLevelRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());
        return redirect()->route('master.job-level.index')->with('success', 'Job Level created successfully.');
    }

    public function edit(string $jobLevel): View
    {
        $data = $this->service->find($jobLevel);
        abort_if(!$data, 404);
        return view('master.job-level.edit', compact('data'));
    }

    public function update(UpdateJobLevelRequest $request, string $jobLevel): RedirectResponse
    {
        $this->service->update($jobLevel, $request->validated());
        return redirect()->route('master.job-level.index')->with('success', 'Job Level updated successfully.');
    }

    public function destroy(string $jobLevel): RedirectResponse
    {
        $this->service->delete($jobLevel);
        return redirect()->route('master.job-level.index')->with('success', 'Job Level deleted successfully.');
    }
}
