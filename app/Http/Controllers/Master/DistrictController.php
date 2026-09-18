<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreDistrictRequest;
use App\Http\Requests\Master\UpdateDistrictRequest;
use App\Models\Master\MsDistrict;
use App\Models\Master\MsCity;
use App\Services\Master\DistrictService;
class DistrictController extends Controller { protected DistrictService $service; public function __construct(DistrictService $service){$this->service=$service;} public function index(){ $districts=$this->service->search(request('search'),10); return view('master.district.index',compact('districts')); } public function create(){ $cities=MsCity::where('IsActive',true)->whereNull('DeletedDate')->orderBy('City')->get(); return view('master.district.create',compact('cities')); } public function store(StoreDistrictRequest $request){$this->service->create($request->validated());return redirect()->route('master.district.index')->with('success','District berhasil ditambahkan.');} public function edit(MsDistrict $district){$cities=MsCity::where('IsActive',true)->whereNull('DeletedDate')->orderBy('City')->get();return view('master.district.edit',['data' => $district, 'cities' => $cities]);} public function update(UpdateDistrictRequest $request,MsDistrict $district){$this->service->update($district->DistrictID,$request->validated());return redirect()->route('master.district.index')->with('success','District berhasil diperbarui.');} public function destroy(MsDistrict $district){$this->service->delete($district->DistrictID);return redirect()->route('master.district.index')->with('success','District berhasil dihapus.');} }

