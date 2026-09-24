<?php
namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreCurrencyRequest;
use App\Http\Requests\Master\UpdateCurrencyRequest;
use App\Services\Master\CurrencyService;
use Illuminate\Http\Request;
class CurrencyController extends Controller{public function __construct(protected CurrencyService $service){} public function index(Request $r){$currencies=$this->service->getAll($r->input('search'));return view('master.currency.index',compact('currencies'));}public function create(){return view('master.currency.create');}public function store(StoreCurrencyRequest $r){$this->service->store($r->validated());return redirect()->route('master.currency.index')->with('success','Currency berhasil ditambahkan.');}public function edit(string $id){$currency=$this->service->findById($id);return view('master.currency.edit',compact('currency'));}public function update(UpdateCurrencyRequest $r,string $id){$this->service->update($id,$r->validated());return redirect()->route('master.currency.index')->with('success','Currency berhasil diupdate.');}public function destroy(string $id){$this->service->delete($id);return redirect()->route('master.currency.index')->with('success','Currency berhasil dihapus.');}}
