@extends('layouts.app')
@section('title', 'City')
@section('content')
<div class="card">
    <div class="card-header"><h5 class="mb-0">Edit City</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ route('master.city.update', $data->CityID) }}">
            @csrf @method('PUT')
            <div class="mb-3"><label class="form-label">City ID</label><input type="text" name="CityID" class="form-control" value="{{ old('CityID', $data->CityID) }}"></div>
            <div class="mb-3"><label class="form-label">Province</label><select name="ProvinceID" class="form-select"><option value="">-- Pilih Province --</option>@foreach($provinces as $item)<option value="{{ $item->ProvinceID }}" @selected(old('ProvinceID', $data->ProvinceID) == $item->ProvinceID)>{{ $item->Province }}</option>@endforeach</select></div>
            <div class="mb-3"><label class="form-label">City</label><input type="text" name="City" class="form-control" value="{{ old('City', $data->City) }}"></div>
            <div class="mb-3"><label class="form-label">Status</label><select name="IsActive" class="form-select"><option value="1" @selected(old('IsActive', $data->IsActive))>Active</option><option value="0" @selected(!old('IsActive', $data->IsActive))>Inactive</option></select></div>
            <button class="btn btn-primary">Simpan</button> <a href="{{ route('master.city.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
