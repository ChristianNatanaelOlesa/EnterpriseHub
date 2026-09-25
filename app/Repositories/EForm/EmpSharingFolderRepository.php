<?php

namespace App\Repositories\EForm;

use App\Models\EForm\TrEmpSharingFolder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmpSharingFolderRepository
{
    public function __construct(protected TrEmpSharingFolder $model)
    {
    }

    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['empForm', 'division', 'details.folderPath', 'details.parentFolder'])
            ->when($search, function ($query) use ($search) {
                $like = "%{$search}%";

                $query->where(function ($q) use ($like) {
                    $q->where('EmpSharingFolderID', 'like', $like)
                        ->orWhere('EmpFormID', 'like', $like)
                        ->orWhere('ReqUser', 'like', $like)
                        ->orWhere('ReqType', 'like', $like)
                        ->orWhere('FolderRequestType', 'like', $like)
                        ->orWhere('Purpose', 'like', $like)
                        ->orWhere('Notes', 'like', $like)
                        ->orWhere('Status', 'like', $like)
                        ->orWhereHas('division', function ($d) use ($like) {
                            $d->where('DivisionName', 'like', $like)
                                ->orWhere('DivisionCode', 'like', $like);
                        })
                        ->orWhereHas('details.folderPath', function ($f) use ($like) {
                            $f->where('FolderName', 'like', $like)
                                ->orWhere('FolderPath', 'like', $like);
                        })
                        ->orWhereHas('details', function ($d) use ($like) {
                            $d->where('FolderName', 'like', $like)
                                ->orWhere('RequestedPath', 'like', $like);
                        });
                });
            })
            ->orderByDesc('InputDate')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(string $id): ?TrEmpSharingFolder
    {
        return $this->model->newQuery()
            ->with([
                'empForm',
                'division',
                'details.folderPath',
                'details.parentFolder',
            ])
            ->find($id);
    }

    public function create(array $data): TrEmpSharingFolder
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

        return $model ? $model->delete() : false;
    }
}
