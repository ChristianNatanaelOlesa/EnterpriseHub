\n@extends('layouts.app')\n@section('title', 'Tambah Currency')\n@section('content')\n<x-alert /><x-card>
    <div class="card-header">
        <h5 class="mb-0">Tambah Currency</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('master.currency.store') }}">@csrf<div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Currency ID <span
                            class="text-danger">*</span></label><input type="text" name="CcyID" class="form-control"
                        value="{{ old('CcyID') }}" maxlength="10"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Currency Name <span
                            class="text-danger">*</span></label><input type="text" name="Currency"
                        class="form-control" value="{{ old('Currency') }}" maxlength="100"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Priority <span
                            class="text-danger">*</span></label><input type="number" name="Priority"
                        class="form-control" value="{{ old('Priority') }}" min="1"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Active</label>
                    <div class="form-check form-switch mt-2"><input type="hidden" name="IsActive" value="0"><input
                            class="form-check-input" type="checkbox" name="IsActive" value="1" checked></div>
                </div>
            </div>
            <div class="mt-3"><button class="btn btn-primary">Save</button> <a
                    href="{{ route('master.currency.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
</x-card>\n@endsection\nr
