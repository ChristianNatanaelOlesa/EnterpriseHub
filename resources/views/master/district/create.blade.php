@extends('layouts.app')
@section('title', 'District')
@section('content')
<div class="card"><div class="card-header"><h5 class="mb-0">Tambah District</h5></div><div class="card-body">
<form method="POST" action="{{ route('master.district.store') }}">@csrf
<div class="mb-3"><label class="form-label">District ID</label><input type="text" name="DistrictID" class="form-control @error('DistrictID') is-invalid @enderror" value="{{ old('DistrictID') }}">@error('DistrictID')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">City</label><select name="CityID" class="form-select @error('CityID') is-invalid @enderror"><option value="">-- Pilih City --</option>@foreach($cities as $item)<option value="{{ $item->CityID }}" @selected(old('CityID') == $item->CityID)>{{ $item->City }}</option>@endforeach</select>@error('CityID')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">District</label><input type="text" name="District" class="form-control @error('District') is-invalid @enderror" value="{{ old('District') }}">@error('District')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Status</label><select name="IsActive" class="form-select"><option value="1" selected>Active</option><option value="0">Inactive</option></select></div>
<button class="btn btn-primary">Simpan</button> <a href="{{ route('master.district.index') }}" class="btn btn-secondary">Kembali</a>
</form></div></div>
@endsection
