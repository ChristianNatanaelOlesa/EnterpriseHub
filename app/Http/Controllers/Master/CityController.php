<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCityRequest;
use App\Http\Requests\Master\UpdateCityRequest;
use App\Models\Master\MsCity;
use App\Models\Master\MsProvince;
use App\Services\Master\CityService;
class CityController extends Controller { protected CityService $service; public function __construct(CityService $service){$this->service=$service;} public function index(){ $cities=$this->service->search(request('search'),10); return view('master.city.index',compact('cities')); } public function create(){ $provinces=MsProvince::where('IsActive',true)->whereNull('DeletedDate')->orderBy('Province')->get(); return view('master.city.create',compact('provinces')); } public function store(StoreCityRequest $request){$this->service->create($request->validated());return redirect()->route('master.city.index')->with('success','City berhasil ditambahkan.');} public function edit(MsCity $city){$provinces=MsProvince::where('IsActive',true)->whereNull('DeletedDate')->orderBy('Province')->get();return view('master.city.edit',['data' => $city, 'provinces' => $provinces]);} public function update(UpdateCityRequest $request,MsCity $city){$this->service->update($city->CityID,$request->validated());return redirect()->route('master.city.index')->with('success','City berhasil diperbarui.');} public function destroy(MsCity $city){$this->service->delete($city->CityID);return redirect()->route('master.city.index')->with('success','City berhasil dihapus.');} }

