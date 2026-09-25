<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreFolderPathRequest;
use App\Http\Requests\Master\UpdateFolderPathRequest;
use App\Services\Master\FolderPathService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FolderPathController extends Controller
{
    public function __construct(protected FolderPathService $service)
    {
    }

    public function index(Request $request): View
    {
        $data = $this->service->getAll(
            $request->input('search'),
            (int) $request->input('perPage', 10)
        );

        return view('master.folder-path.index', compact('data'));
    }

    public function create(): View
    {
        return view('master.folder-path.create', [
            'parents' => $this->service->activeList(),
        ]);
    }

    public function store(StoreFolderPathRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('master.folder-path.index')
            ->with('success', 'Folder Path created successfully.');
    }

    public function edit(string $folder_path): View
    {
        $data = $this->service->find($folder_path);

        abort_if(!$data, 404);

        return view('master.folder-path.edit', [
            'data' => $data,
            'parents' => $this->service->activeList()
                ->where('FolderPathID', '!=', $folder_path),
        ]);
    }

    public function update(
        UpdateFolderPathRequest $request,
        string $folder_path
    ): RedirectResponse {
        $this->service->update(
            $folder_path,
            $request->validated()
        );

        return redirect()
            ->route('master.folder-path.index')
            ->with('success', 'Folder Path updated successfully.');
    }

    public function destroy(string $folder_path): RedirectResponse
    {
        $this->service->delete($folder_path);

        return redirect()
            ->route('master.folder-path.index')
            ->with('success', 'Folder Path deleted successfully.');
    }
}
