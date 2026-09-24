<?php
namespace App\Http\Controllers\EForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpNetworkRequest;
use App\Http\Requests\EForm\UpdateEmpNetworkRequest;
use App\Models\EForm\TrEmpForm;
use App\Services\EForm\EmpNetworkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class EmpNetworkController extends Controller
{
    public function __construct(protected EmpNetworkService $service) {}
    public function index(Request $request): View { $data=$this->service->getAll($request->input('search'),(int)$request->input('perPage',10)); return view('eform.employee-network.index',compact('data')); }
    public function create(): View { $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-network.create',compact('employees')); }
    public function store(StoreEmpNetworkRequest $request): RedirectResponse { $payload=$request->validated(); $payload['EmpNetworkID']=$this->service->generateId();         $payload['WLAN']=$request->boolean('WLAN');
        $payload['Internet']=$request->boolean('Internet');
        $payload['VPN']=$request->boolean('VPN');
$this->service->create($payload); return redirect()->route('employee-network.index')->with('success','Employee Network created successfully.'); }
    public function edit(string $EmpNetworkID): View { $data=$this->service->find($EmpNetworkID); abort_if(!$data,404); $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-network.edit',compact('data','employees')); }
    public function update(UpdateEmpNetworkRequest $request,string $EmpNetworkID): RedirectResponse { $payload=$request->validated();         $payload['WLAN']=$request->boolean('WLAN');
        $payload['Internet']=$request->boolean('Internet');
        $payload['VPN']=$request->boolean('VPN');
$this->service->update($EmpNetworkID,$payload); return redirect()->route('employee-network.index')->with('success','Employee Network updated successfully.'); }
    public function destroy(string $EmpNetworkID): RedirectResponse { $this->service->delete($EmpNetworkID); return redirect()->route('employee-network.index')->with('success','Employee Network deleted successfully.'); }
}
