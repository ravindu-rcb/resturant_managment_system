<?php

namespace App\Repositories\Eloquent;

use App\Models\Concession;
use App\Repositories\ConcessionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentConcessionRepository implements ConcessionRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Concession::latest()->paginate($perPage);
    }

    public function all(): iterable
    {
        return Concession::orderBy('name')->get();
    }

    public function find(int $id): ?Concession
    {
        return Concession::find($id);
    }

    public function create(array $data): Concession
    {
        return Concession::create($data);
    }

    public function update(Concession $concession, array $data): Concession
    {
        $concession->update($data);
        return $concession;
    }

    public function delete(Concession $concession): void
    {
        $concession->delete();
    }
}
