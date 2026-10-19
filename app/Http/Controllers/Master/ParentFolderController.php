<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreParentFolderRequest;
use App\Http\Requests\Master\UpdateParentFolderRequest;
use App\Services\Master\ParentFolderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class ParentFolderController extends Controller
{
 public function __construct(protected ParentFolderService $service){}
 public function index(Request $request):View{return view('master.parent-folder.index',['data'=>$this->service->getAll($request->input('search'),(int)$request->input('perPage',10))]);}
 public function create():View{return view('master.parent-folder.create');}
 public function store(StoreParentFolderRequest $request):RedirectResponse{$this->service->create($request->validated());return redirect()->route('master.parent-folder.index')->with('success','Parent Folder created successfully.');}
 public function edit(string $parent_folder):View{$data=$this->service->find($parent_folder);abort_if(!$data,404);return view('master.parent-folder.edit',compact('data'));}
 public function update(UpdateParentFolderRequest $request,string $parent_folder):RedirectResponse{$this->service->update($parent_folder,$request->validated());return redirect()->route('master.parent-folder.index')->with('success','Parent Folder updated successfully.');}
 public function destroy(string $parent_folder):RedirectResponse{$this->service->delete($parent_folder);return redirect()->route('master.parent-folder.index')->with('success','Parent Folder deleted successfully.');}
}
