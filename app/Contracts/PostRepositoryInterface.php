<?php

namespace App\Contracts;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function findAll(): Collection;
    public function findById(int $id): ?Post;
    public function findBySlug(string $slug): ?Post;
    public function findPublished(): Collection;
    public function findByCategory(int $categoryId): Collection;
    public function findByAuthor(int $authorId): Collection;
    public function findByTag(int $tagId): Collection;
    public function search(string $query): Collection;
    public function create(array $data): Post;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function incrementViews(int $id): bool;
    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator;
}