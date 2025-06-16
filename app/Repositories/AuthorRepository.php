<?php

namespace App\Repositories;

use App\Models\Author;
use App\Contracts\AuthorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function __construct(protected Author $model) {}

    public function findAll(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Author
    {
        return $this->model->find($id);
    }

    public function findActive(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    public function create(array $data): Author
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $author = $this->findById($id);
        return $author ? $author->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $author = $this->findById($id);
        return $author ? $author->delete() : false;
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }
}