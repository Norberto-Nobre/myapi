<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Contracts\TagRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository implements TagRepositoryInterface
{
    public function __construct(protected Tag $model) {}

    public function findAll(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Tag
    {
        return $this->model->find($id);
    }

    public function findBySlug(string $slug): ?Tag
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function findActive(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }

    public function create(array $data): Tag
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $tag = $this->findById($id);
        return $tag ? $tag->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $tag = $this->findById($id);
        return $tag ? $tag->delete() : false;
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }
}