<?php

namespace App\Repositories;

use App\Models\Concession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ConcessionRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function all(): iterable;
    public function find(int $id): ?Concession;
    public function create(array $data): Concession;
    public function update(Concession $concession, array $data): Concession;
    public function delete(Concession $concession): void;
}
