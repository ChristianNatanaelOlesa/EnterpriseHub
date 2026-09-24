<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreAssetRequest;
use App\Http\Requests\Master\UpdateAssetRequest;
use App\Services\Master\AssetService;
use App\Services\Master\AssetTypeService;
use App\Services\Master\CurrencyService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function __construct(protected AssetService $service, protected AssetTypeService $typeService, protected CurrencyService $currencyService)
    {
    } public function index(Request $r)
    {
        $assets = $this->service->getAll($r->input('search'));
        return view('master.asset.index', compact('assets'));
    }public function create()
    {
        $assetTypes = $this->typeService->getAll(null);
        $currencies = $this->currencyService->getAll(null);
        return view('master.asset.create', compact('assetTypes', 'currencies'));
    }public function store(StoreAssetRequest $r)
    {
        $this->service->store($r->validated());
        return redirect()->route('master.asset.index')->with('success', 'Asset berhasil ditambahkan.');
    }public function edit(string $id)
    {
        $asset = $this->service->findById($id);
        $assetTypes = $this->typeService->getAll(null);
        $currencies = $this->currencyService->getAll(null);
        return view('master.asset.edit', compact('asset', 'assetTypes', 'currencies'));
    }public function update(UpdateAssetRequest $r, string $id)
    {
        $this->service->update($id, $r->validated());
        return redirect()->route('master.asset.index')->with('success', 'Asset berhasil diupdate.');
    }public function destroy(string $id)
    {
        $this->service->delete($id);
        return redirect()->route('master.asset.index')->with('success','Asset berhasil dihapus.');
    }
}
