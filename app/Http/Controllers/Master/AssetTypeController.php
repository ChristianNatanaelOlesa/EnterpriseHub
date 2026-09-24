<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreAssetTypeRequest;
use App\Http\Requests\Master\UpdateAssetTypeRequest;
use App\Services\Master\AssetTypeService;
use App\Services\Master\AssetGroupService;
use Illuminate\Http\Request;
class AssetTypeController extends Controller{public function __construct(protected AssetTypeService $service,protected AssetGroupService $groupService){} public function index(Request $r){$assetTypes=$this->service->getAll($r->input('search'));return view('master.asset-type.index',compact('assetTypes'));}public function create(){$assetGroups=$this->groupService->getAll(null);return view('master.asset-type.create',compact('assetGroups'));}public function store(StoreAssetTypeRequest $r){$this->service->store($r->validated());return redirect()->route('master.asset-type.index')->with('success','Asset Type berhasil ditambahkan.');}public function edit(string $id){$assetType=$this->service->findById($id);$assetGroups=$this->groupService->getAll(null);return view('master.asset-type.edit',compact('assetType','assetGroups'));}public function update(UpdateAssetTypeRequest $r,string $id){$this->service->update($id,$r->validated());return redirect()->route('master.asset-type.index')->with('success','Asset Type berhasil diupdate.');}public function destroy(string $id){$this->service->delete($id);return redirect()->route('master.asset-type.index')->with('success','Asset Type berhasil dihapus.');}}
