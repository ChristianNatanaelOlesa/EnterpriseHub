<?php
namespace App\Http\Controllers\EForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpITAreaRequest;
use App\Http\Requests\EForm\UpdateEmpITAreaRequest;
use App\Models\EForm\TrEmpForm;
use App\Services\EForm\EmpITAreaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class EmpITAreaController extends Controller
{
    public function __construct(protected EmpITAreaService $service) {}
    public function index(Request $request): View { $data=$this->service->getAll($request->input('search'),(int)$request->input('perPage',10)); return view('eform.employee-it-area.index',compact('data')); }
    public function create(): View { $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-it-area.create',compact('employees')); }
    public function store(StoreEmpITAreaRequest $request): RedirectResponse { $payload=$request->validated(); $payload['EmpITAreaID']=$this->service->generateId();         $payload['EmailOnTablet']=$request->boolean('EmailOnTablet');
        $payload['EmailOnPhone']=$request->boolean('EmailOnPhone');
        $payload['Fingerprint']=$request->boolean('Fingerprint');
        $payload['CCTV']=$request->boolean('CCTV');
        $payload['Firewall']=$request->boolean('Firewall');
        $payload['ExternalDrive']=$request->boolean('ExternalDrive');
        $payload['DataCenter']=$request->boolean('DataCenter');
$this->service->create($payload); return redirect()->route('employee-it-area.index')->with('success','Employee IT Area created successfully.'); }
    public function edit(string $EmpITAreaID): View { $data=$this->service->find($EmpITAreaID); abort_if(!$data,404); $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-it-area.edit',compact('data','employees')); }
    public function update(UpdateEmpITAreaRequest $request,string $EmpITAreaID): RedirectResponse { $payload=$request->validated();         $payload['EmailOnTablet']=$request->boolean('EmailOnTablet');
        $payload['EmailOnPhone']=$request->boolean('EmailOnPhone');
        $payload['Fingerprint']=$request->boolean('Fingerprint');
        $payload['CCTV']=$request->boolean('CCTV');
        $payload['Firewall']=$request->boolean('Firewall');
        $payload['ExternalDrive']=$request->boolean('ExternalDrive');
        $payload['DataCenter']=$request->boolean('DataCenter');
$this->service->update($EmpITAreaID,$payload); return redirect()->route('employee-it-area.index')->with('success','Employee IT Area updated successfully.'); }
    public function destroy(string $EmpITAreaID): RedirectResponse { $this->service->delete($EmpITAreaID); return redirect()->route('employee-it-area.index')->with('success','Employee IT Area deleted successfully.'); }
}
