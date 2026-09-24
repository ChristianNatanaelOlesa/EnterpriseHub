<?php
namespace App\Http\Controllers\EForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\EForm\StoreEmpInfraRequest;
use App\Http\Requests\EForm\UpdateEmpInfraRequest;
use App\Models\EForm\TrEmpForm;
use App\Services\EForm\EmpInfraService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class EmpInfraController extends Controller
{
    public function __construct(protected EmpInfraService $service) {}
    public function index(Request $request): View { $data=$this->service->getAll($request->input('search'),(int)$request->input('perPage',10)); return view('eform.employee-infra.index',compact('data')); }
    public function create(): View { $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-infra.create',compact('employees')); }
    public function store(StoreEmpInfraRequest $request): RedirectResponse { $payload=$request->validated(); $payload['EmpInfraID']=$this->service->generateId(); $this->service->create($payload); return redirect()->route('employee-infra.index')->with('success','Employee Infrastructure created successfully.'); }
    public function edit(string $EmpInfraID): View { $data=$this->service->find($EmpInfraID); abort_if(!$data,404); $employees=TrEmpForm::query()->orderBy('FirstName')->orderBy('LastName')->get(); return view('eform.employee-infra.edit',compact('data','employees')); }
    public function update(UpdateEmpInfraRequest $request,string $EmpInfraID): RedirectResponse { $payload=$request->validated(); $this->service->update($EmpInfraID,$payload); return redirect()->route('employee-infra.index')->with('success','Employee Infrastructure updated successfully.'); }
    public function destroy(string $EmpInfraID): RedirectResponse { $this->service->delete($EmpInfraID); return redirect()->route('employee-infra.index')->with('success','Employee Infrastructure deleted successfully.'); }
}
