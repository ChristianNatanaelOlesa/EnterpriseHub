<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function all()
    {
        return $this->model
            ->whereNull('DeletedDate')
            ->get();
    }

    public function find(int $id)
    {
        return $this->model
            ->where($this->model->getKeyName(), $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $model = $this->find($id);

        $model->update($data);

        return $model->fresh();
    }

    public function delete(int $id)
    {
        $model = $this->find($id);

        $model->update([
            'IsActive' => false,
            'DeletedBy' => auth()->check()
                ? auth()->user()->UserID
                : null,
            'DeletedDate' => now(),
        ]);

        return $model->fresh();
    }
}
