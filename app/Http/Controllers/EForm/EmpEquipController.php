<?php
namespace App\Http\Controllers\EForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpEquipRequest;
use App\Http\Requests\EForm\UpdateEmpEquipRequest;
use App\Services\EForm\EmpEquipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
class EmpEquipController extends Controller
{
 public function __construct(protected EmpEquipService $service){}
 public function index(Request $request):View{$search=trim((string)$request->input('search',''));$employeeEquipments=$this->service->getAll($search,10);return view('eform.employee-equipment.index',compact('employeeEquipments','search'));}
 public function create(Request $request):View{$empForm=$this->service->currentEmployeeForm();$assetTypes=$this->service->getAssetTypes();$assetTypeId=$request->input('AssetTypeID');$assetSearch=trim((string)$request->input('asset_search',''));$assets=$this->service->getAvailableAssets($assetTypeId,$assetSearch);return view('eform.employee-equipment.create',compact('empForm','assetTypes','assetTypeId','assetSearch','assets'));}
 public function store(StoreEmpEquipRequest $request):RedirectResponse{try{$data=$request->validated();$count=$this->service->createMany($data,$data['AssetID']);return redirect()->route('employee-equipment.index')->with('success',$count.' Employee Equipment transaction berhasil dibuat.');}catch(RuntimeException $e){return back()->withInput()->with('error',$e->getMessage());}}
 public function edit(Request $request,string $employeeEquipment):View{$equipment=$this->service->find($employeeEquipment);abort_if(!$equipment,404);$assetTypes=$this->service->getAssetTypes();$assetTypeId=$request->input('AssetTypeID')?:$equipment->asset?->AssTypeID;$assetSearch=trim((string)$request->input('asset_search',''));$assets=$this->service->getAvailableAssets($assetTypeId,$assetSearch);return view('eform.employee-equipment.edit',compact('equipment','assetTypes','assetTypeId','assetSearch','assets'));}
 public function update(UpdateEmpEquipRequest $request,string $employeeEquipment):RedirectResponse{try{$this->service->update($employeeEquipment,$request->validated());return redirect()->route('employee-equipment.index')->with('success','Employee Equipment berhasil diupdate.');}catch(RuntimeException $e){return back()->withInput()->with('error',$e->getMessage());}}
 public function destroy(string $employeeEquipment):RedirectResponse{try{$this->service->delete($employeeEquipment);return redirect()->route('employee-equipment.index')->with('success','Employee Equipment berhasil dihapus.');}catch(RuntimeException $e){return back()->with('error',$e->getMessage());}}
}
