<?php

namespace App\Contracts;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TagRepositoryInterface
{
    public function findAll(): Collection;
    public function findById(int $id): ?Tag;
    public function findBySlug(string $slug): ?Tag;
    public function findActive(): Collection;
    public function create(array $data): Tag;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
}