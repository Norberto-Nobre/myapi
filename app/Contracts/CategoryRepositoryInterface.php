<?php

namespace App\Contracts;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function findAll(): Collection;
    public function findById(int $id): ?Category;
    public function findBySlug(string $slug): ?Category;
    public function findActive(): Collection;
    public function create(array $data): Category;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
}