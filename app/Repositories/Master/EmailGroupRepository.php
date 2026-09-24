<?php

namespace App\Repositories\Master;

use App\Models\Master\MsEmailGroup;
use App\Repositories\BaseRepository;

class EmailGroupRepository extends BaseRepository
{
    public function __construct(MsEmailGroup $model)
    {
        $this->model = $model;
    }

    public function search(?string $keyword = null, int $perPage = 10)
    {
        return $this->model
            ->with('division')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('EmailGroupID', 'like', "%{$keyword}%")
                        ->orWhere('Email', 'like', "%{$keyword}%")
                        ->orWhere('Description', 'like', "%{$keyword}%")
                        ->orWhereHas('division', function ($q) use ($keyword) {
                            $q->where('DivisionName', 'like', "%{$keyword}%");
                        });
                });
            })
            ->whereNull('DeletedDate')
            ->orderBy('EmailGroupID')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findById(string $id)
    {
        return $this->model
            ->with('division')
            ->where('EmailGroupID', $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();
    }

    /**
     * EmailGroupID is a string primary key (e.g. EG001), so do not use
     * BaseRepository::update(), which expects an integer primary key.
     */
    public function updateById(string $id, array $data)
    {
        $model = $this->model
            ->where('EmailGroupID', $id)
            ->whereNull('DeletedDate')
            ->firstOrFail();

        $model->update($data);

        return $model->fresh(['division']);
    }

    /**
     * EmailGroupID is a string primary key, so deletion must also use the
     * string-aware lookup instead of BaseRepository::delete().
     */
    public function deleteById(string $id, array $data)
    {
        return $this->updateById($id, $data);
    }
}
