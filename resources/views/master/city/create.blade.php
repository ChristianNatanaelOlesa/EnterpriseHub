@extends('layouts.app')

@section('title', 'City')

@section('content')
<div class="card">
    <div class="card-header"><h5 class="mb-0">Tambah City</h5></div>
    <div class="card-body">
        <form method="POST" action="{{ route('master.city.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">City ID</label>
                <input type="text" name="CityID" class="form-control @error('CityID') is-invalid @enderror" value="{{ old('CityID') }}">
                @error('CityID')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Province</label>
                <select name="ProvinceID" class="form-select @error('ProvinceID') is-invalid @enderror">
                    <option value="">-- Pilih Province --</option>
                    @foreach($provinces as $item)
                        <option value="{{ $item->ProvinceID }}" @selected(old('ProvinceID') == $item->ProvinceID)>{{ $item->Province }}</option>
                    @endforeach
                </select>
                @error('ProvinceID')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" name="City" class="form-control @error('City') is-invalid @enderror" value="{{ old('City') }}">
                @error('City')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="IsActive" class="form-select"><option value="1" selected>Active</option><option value="0">Inactive</option></select>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('master.city.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
