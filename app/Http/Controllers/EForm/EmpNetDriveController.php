<?php
namespace App\Http\Controllers\EForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpNetDriveRequest;
use App\Http\Requests\EForm\UpdateEmpNetDriveRequest;
use App\Models\EForm\TrEmpForm;
use App\Services\EForm\EmpNetDriveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class EmpNetDriveController extends Controller
{
    public function __construct(protected EmpNetDriveService $service) {}
    public function index(Request $request): View { $data=$this->service->getAll($request->input('search'),(int)$request->input('perPage',10)); return view('eform.employee-network-drive.index',compact('data')); }
    public function create(): View { $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-network-drive.create',compact('employees')); }
    public function store(StoreEmpNetDriveRequest $request): RedirectResponse { $payload=$request->validated(); $payload['EmpNetDriveID']=$this->service->generateId(); $this->service->create($payload); return redirect()->route('employee-network-drive.index')->with('success','Employee Network Drive created successfully.'); }
    public function edit(string $EmpNetDriveID): View { $data=$this->service->find($EmpNetDriveID); abort_if(!$data,404); $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-network-drive.edit',compact('data','employees')); }
    public function update(UpdateEmpNetDriveRequest $request,string $EmpNetDriveID): RedirectResponse { $payload=$request->validated(); $this->service->update($EmpNetDriveID,$payload); return redirect()->route('employee-network-drive.index')->with('success','Employee Network Drive updated successfully.'); }
    public function destroy(string $EmpNetDriveID): RedirectResponse { $this->service->delete($EmpNetDriveID); return redirect()->route('employee-network-drive.index')->with('success','Employee Network Drive deleted successfully.'); }
}
