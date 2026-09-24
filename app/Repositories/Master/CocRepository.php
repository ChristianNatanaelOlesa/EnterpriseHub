<?php

namespace App\Repositories\Master;

use App\Models\Master\MsCoc;
use Illuminate\Pagination\LengthAwarePaginator;

class CocRepository
{
    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return MsCoc::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('CocID', 'like', "%{$search}%")
                        ->orWhere('Name', 'like', "%{$search}%")
                        ->orWhere('Description', 'like', "%{$search}%");
                });
            })
            ->orderBy('InputDate', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(string $id): ?MsCoc
    {
        return MsCoc::query()
            ->where('CocID', $id)
            ->first();
    }
}
