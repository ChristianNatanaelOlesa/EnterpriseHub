<?php

namespace App\Repositories\EForm;

use App\Models\EForm\TrEmpApp;

class EmpAppRepository
{
    public function __construct(
        protected TrEmpApp $model
    ) {
    }

    public function find(string $id): ?TrEmpApp
    {
        return $this->model->newQuery()
            ->with('empForm')
            ->find($id);
    }

    public function create(array $data): TrEmpApp
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(string $id, array $data): bool
    {
        $model = $this->find($id);

        return $model ? $model->update($data) : false;
    }

    public function delete(string $id): bool
    {
        $model = $this->find($id);

        return $model ? (bool) $model->delete() : false;
    }
}
