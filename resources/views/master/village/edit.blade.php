@extends('layouts.app')
@section('title', 'Village')
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Village</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('master.village.update', $data->VillageID) }}">@csrf @method('PUT')
                <div class="mb-3"><label class="form-label">Village ID</label><input type="text" name="VillageID"
                        class="form-control" value="{{ old('VillageID', $data->VillageID) }}"></div>
                <div class="mb-3"><label class="form-label">District</label><select name="DistrictID" class="form-select">
                        <option value="">-- Pilih District --</option>
                        @foreach ($districts as $item)
                            <option value="{{ $item->DistrictID }}" @selected(old('DistrictID', $data->DistrictID) == $item->DistrictID)>{{ $item->District }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">Village</label><input type="text" name="Village"
                        class="form-control" value="{{ old('Village', $data->Village) }}"></div>
                <div class="mb-3"><label class="form-label">Postal Code</label><input type="text" name="PostalCode"
                        class="form-control @error('PostalCode') is-invalid @enderror"
                        value="{{ old('PostalCode', $data->PostalCode) }}">
                    @error('PostalCode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3"><label class="form-label">Status</label><select name="IsActive" class="form-select">
                        <option value="1" @selected(old('IsActive', $data->IsActive))>Active</option>
                        <option value="0" @selected(!old('IsActive', $data->IsActive))>Inactive</option>
                    </select></div>
                <button class="btn btn-primary">Simpan</button> <a href="{{ route('master.village.index') }}"
                    class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
