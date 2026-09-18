@extends('layouts.app')
@section('title', 'Village')
@section('content')
<div class="card"><div class="card-header"><h5 class="mb-0">Tambah Village</h5></div><div class="card-body">
<form method="POST" action="{{ route('master.village.store') }}">@csrf
<div class="mb-3"><label class="form-label">Village ID</label><input type="text" name="VillageID" class="form-control @error('VillageID') is-invalid @enderror" value="{{ old('VillageID') }}">@error('VillageID')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">District</label><select name="DistrictID" class="form-select @error('DistrictID') is-invalid @enderror"><option value="">-- Pilih District --</option>@foreach($districts as $item)<option value="{{ $item->DistrictID }}" @selected(old('DistrictID') == $item->DistrictID)>{{ $item->District }}</option>@endforeach</select>@error('DistrictID')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Village</label><input type="text" name="Village" class="form-control @error('Village') is-invalid @enderror" value="{{ old('Village') }}">@error('Village')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Postal Code</label><input type="text" name="PostalCode" class="form-control @error('PostalCode') is-invalid @enderror" value="{{ old('PostalCode') }}">@error('PostalCode')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Status</label><select name="IsActive" class="form-select"><option value="1" selected>Active</option><option value="0">Inactive</option></select></div>
<button class="btn btn-primary">Simpan</button> <a href="{{ route('master.village.index') }}" class="btn btn-secondary">Kembali</a>
</form></div></div>
@endsection
