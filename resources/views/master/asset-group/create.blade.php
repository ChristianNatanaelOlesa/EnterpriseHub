\n@extends('layouts.app')\n@section('title', 'Tambah Asset Group')\n@section('content')\n<x-alert /><x-card>
    <div class="card-header">
        <h5 class="mb-0">Tambah Asset Group</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('master.asset-group.store') }}">@csrf<div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Asset Group ID <span
                            class="text-danger">*</span></label><input type="text" name="AssGroupID"
                        class="form-control" value="{{ old('AssGroupID') }}" maxlength="50"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Asset Group <span
                            class="text-danger">*</span></label><input type="text" name="AssetGroup"
                        class="form-control" value="{{ old('AssetGroup') }}" maxlength="200"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Commercial Lifetime <span
                            class="text-danger">*</span></label><input type="number" name="ComLifetime"
                        class="form-control" value="{{ old('ComLifetime') }}" step="0.01"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Fiscal Lifetime <span
                            class="text-danger">*</span></label><input type="number" name="FiscalLifetime"
                        class="form-control" value="{{ old('FiscalLifetime') }}" step="0.01"></div>
                <div class="col-12 mb-3"><label class="form-label">Description <span
                            class="text-danger">*</span></label>
                    <textarea name="Description" class="form-control" rows="4" required>{{ old('Description') }}</textarea>
                </div>
                <div class="col-md-6 mb-3"><label class="form-label">Active</label>
                    <div class="form-check form-switch mt-2"><input type="hidden" name="IsActive" value="0"><input
                            class="form-check-input" type="checkbox" name="IsActive" value="1" checked></div>
                </div>
            </div>
            <div class="mt-3"><button class="btn btn-primary">Save</button> <a
                    href="{{ route('master.asset-group.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-card>\n@endsection\nr
