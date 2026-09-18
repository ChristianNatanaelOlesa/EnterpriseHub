<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreVillageRequest;
use App\Http\Requests\Master\UpdateVillageRequest;
use App\Models\Master\MsVillage;
use App\Models\Master\MsDistrict;
use App\Services\Master\VillageService;
class VillageController extends Controller { protected VillageService $service; public function __construct(VillageService $service){$this->service=$service;} public function index(){ $villages=$this->service->search(request('search'),10); return view('master.village.index',compact('villages')); } public function create(){ $districts=MsDistrict::where('IsActive',true)->whereNull('DeletedDate')->orderBy('District')->get(); return view('master.village.create',compact('districts')); } public function store(StoreVillageRequest $request){$this->service->create($request->validated());return redirect()->route('master.village.index')->with('success','Village berhasil ditambahkan.');} public function edit(MsVillage $village){$districts=MsDistrict::where('IsActive',true)->whereNull('DeletedDate')->orderBy('District')->get();return view('master.village.edit',['data' => $village, 'districts' => $districts]);} public function update(UpdateVillageRequest $request,MsVillage $village){$this->service->update($village->VillageID,$request->validated());return redirect()->route('master.village.index')->with('success','Village berhasil diperbarui.');} public function destroy(MsVillage $village){$this->service->delete($village->VillageID);return redirect()->route('master.village.index')->with('success','Village berhasil dihapus.');} }

