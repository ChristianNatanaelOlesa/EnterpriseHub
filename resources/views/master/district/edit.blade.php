@extends('layouts.app')
@section('title', 'District')
@section('content')
<div class="card"><div class="card-header"><h5 class="mb-0">Edit District</h5></div><div class="card-body">
<form method="POST" action="{{ route('master.district.update', $data->DistrictID) }}">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">District ID</label><input type="text" name="DistrictID" class="form-control" value="{{ old('DistrictID', $data->DistrictID) }}"></div>
<div class="mb-3"><label class="form-label">City</label><select name="CityID" class="form-select"><option value="">-- Pilih City --</option>@foreach($cities as $item)<option value="{{ $item->CityID }}" @selected(old('CityID', $data->CityID) == $item->CityID)>{{ $item->City }}</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label">District</label><input type="text" name="District" class="form-control" value="{{ old('District', $data->District) }}"></div>
<div class="mb-3"><label class="form-label">Status</label><select name="IsActive" class="form-select"><option value="1" @selected(old('IsActive', $data->IsActive))>Active</option><option value="0" @selected(!old('IsActive', $data->IsActive))>Inactive</option></select></div>
<button class="btn btn-primary">Simpan</button> <a href="{{ route('master.district.index') }}" class="btn btn-secondary">Kembali</a>
</form></div></div>
@endsection
