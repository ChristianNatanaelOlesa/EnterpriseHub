\n@extends('layouts.app')\n@section('title', 'Edit Asset Type')\n@section('content')\n<x-alert />
<x-card>
    <div class="card-header">
        <h5 class="mb-0">Edit Asset Type</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('master.asset-type.update', $$assetType->getKey()) }}">@csrf
            @method('PUT')<div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Asset Type ID <span
                            class="text-danger">*</span></label><input type="text" name="AssTypeID"
                        class="form-control" value="{{ old('AssTypeID', $assetType->AssTypeID) }}" maxlength="50"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Asset Group <span
                            class="text-danger">*</span></label><select name="AssetGroupID" class="form-select"
                        required>
                        <option value="">-- Select Asset Group --</option>
                        @foreach ($assetGroups as $group)
                            <option value="{{ $group->AssGroupID }}" @selected(old('AssetGroupID', $assetType->AssetGroupID) === $group->AssGroupID)>
                                {{ $group->AssGroupID }} - {{ $group->AssetGroup }}</option>
                        @endforeach
                    </select></div>
                <div class="col-md-6 mb-3"><label class="form-label">Asset Type <span
                            class="text-danger">*</span></label><input type="text" name="AssetType"
                        class="form-control" value="{{ old('AssetType', $assetType->AssetType) }}" maxlength="150">
                </div>
                <div class="col-12 mb-3"><label class="form-label">Type Description <span
                            class="text-danger">*</span></label>
                    <textarea name="TypeDesc" class="form-control" rows="4" required>{{ old('TypeDesc', $assetType->TypeDesc) }}</textarea>
                </div>
                <div class="col-md-6 mb-3"><label class="form-label">Active</label>
                    <div class="form-check form-switch mt-2"><input type="hidden" name="IsActive" value="0"><input
                            class="form-check-input" type="checkbox" name="IsActive" value="1"
                            @checked($assetType->IsActive)></div>
                </div>
            </div>
            <div class="mt-3"><button class="btn btn-primary">Update</button> <a
                    href="{{ route('master.asset-type.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-card>\n@endsection\nr
