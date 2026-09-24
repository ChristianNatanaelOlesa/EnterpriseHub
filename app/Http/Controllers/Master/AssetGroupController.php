<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreAssetGroupRequest;
use App\Http\Requests\Master\UpdateAssetGroupRequest;
use App\Services\Master\AssetGroupService;
use Illuminate\Http\Request;
class AssetGroupController extends Controller{public function __construct(protected AssetGroupService $service){} public function index(Request $r){$assetGroups=$this->service->getAll($r->input('search'));return view('master.asset-group.index',compact('assetGroups'));}public function create(){return view('master.asset-group.create');}public function store(StoreAssetGroupRequest $r){$this->service->store($r->validated());return redirect()->route('master.asset-group.index')->with('success','Asset Group berhasil ditambahkan.');}public function edit(string $id){$assetGroup=$this->service->findById($id);return view('master.asset-group.edit',compact('assetGroup'));}public function update(UpdateAssetGroupRequest $r,string $id){$this->service->update($id,$r->validated());return redirect()->route('master.asset-group.index')->with('success','Asset Group berhasil diupdate.');}public function destroy(string $id){$this->service->delete($id);return redirect()->route('master.asset-group.index')->with('success','Asset Group berhasil dihapus.');}}
