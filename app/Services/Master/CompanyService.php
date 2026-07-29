<?php

namespace App\Services\Master;

use App\Models\Master\MsCompany;

class CompanyService
{
    public function getAll()
    {
        return MsCompany::query()
            ->whereNull('DeletedDate')
            ->orderBy('CompanyCode')
            ->get();
    }

    public function find(int $id): MsCompany
    {
        return MsCompany::findOrFail($id);
    }

    public function store(array $data): MsCompany
    {
        $data['CreatedBy'] = null;

        return MsCompany::create($data);
    }

    public function update(int $id, array $data): MsCompany
    {
        $company = $this->find($id);

        $data['UpdatedBy'] = null;

        $company->update($data);

        return $company;
    }

    public function delete(MsCompany $company): void
    {
        $company->DeletedBy = null;
        $company->DeletedDate = now();

        $company->save();
    }

    public function destroy(int $id): void
    {
        $company = $this->find($id);

        $company->delete();
    }


}
