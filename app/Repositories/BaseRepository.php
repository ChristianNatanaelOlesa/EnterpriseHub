<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function all()
    {
        return $this->model->whereNull('DeletedDate')->get();
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->whereNull('DeletedDate')->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->whereNull('DeletedDate')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);

        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
