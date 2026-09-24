<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCocRequest;
use App\Http\Requests\Master\UpdateCocRequest;
use App\Services\Master\CocService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;

class CocController extends Controller
{
    public function __construct(
        protected CocService $cocService
    ) {
    }

    public function index(Request $request): View
    {
        $data = $this->cocService->getAll(
            $request->input('search')
        );

        return view('master.coc.index', compact('data'));
    }

    public function create(): View
    {
        return view('master.coc.create');
    }

    public function store(StoreCocRequest $request): RedirectResponse
    {
        try {
            $this->cocService->create(
                $request->validated(),
                auth()->user()
            );

            return redirect()
                ->route('master.coc.index')
                ->with('success', 'Code Of Conduct berhasil dibuat.');
        } catch (RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit(string $coc): View
    {
        $data = $this->cocService->find($coc);

        return view('master.coc.edit', compact('data'));
    }

    public function update(
        UpdateCocRequest $request,
        string $coc
    ): RedirectResponse {
        try {
            $this->cocService->update(
                $coc,
                $request->validated(),
                auth()->user()
            );

            return redirect()
                ->route('master.coc.index')
                ->with('success', 'Code Of Conduct berhasil diupdate.');
        } catch (RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(string $coc): RedirectResponse
    {
        try {
            $this->cocService->delete($coc);

            return redirect()
                ->route('master.coc.index')
                ->with('success', 'Code Of Conduct berhasil dihapus.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function download(string $coc)
    {
        $data = $this->cocService->find($coc);

        abort_unless(
            $data->FileLoc && Storage::disk('public')->exists($data->FileLoc),
            404
        );

        return Storage::disk('public')->download($data->FileLoc);
    }
}
