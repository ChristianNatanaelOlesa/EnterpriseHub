<?php
namespace App\Http\Controllers\EForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpSoftwareRequest;
use App\Http\Requests\EForm\UpdateEmpSoftwareRequest;
use App\Models\EForm\TrEmpForm;
use App\Services\EForm\EmpSoftwareService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class EmpSoftwareController extends Controller
{
    public function __construct(protected EmpSoftwareService $service) {}
    public function index(Request $request): View { $data=$this->service->getAll($request->input('search'),(int)$request->input('perPage',10)); return view('eform.employee-software.index',compact('data')); }
    public function create(): View { $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-software.create',compact('employees')); }
    public function store(StoreEmpSoftwareRequest $request): RedirectResponse { $payload=$request->validated(); $payload['EmpSoftwareID']=$this->service->generateId(); $this->service->create($payload); return redirect()->route('employee-software.index')->with('success','Employee Software created successfully.'); }
    public function edit(string $EmpSoftwareID): View { $data=$this->service->find($EmpSoftwareID); abort_if(!$data,404); $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-software.edit',compact('data','employees')); }
    public function update(UpdateEmpSoftwareRequest $request,string $EmpSoftwareID): RedirectResponse { $payload=$request->validated(); $this->service->update($EmpSoftwareID,$payload); return redirect()->route('employee-software.index')->with('success','Employee Software updated successfully.'); }
    public function destroy(string $EmpSoftwareID): RedirectResponse { $this->service->delete($EmpSoftwareID); return redirect()->route('employee-software.index')->with('success','Employee Software deleted successfully.'); }
}
