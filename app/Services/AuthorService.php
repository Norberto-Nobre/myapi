<?php

namespace App\Services;

use App\Contracts\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorService
{
    public function __construct(protected AuthorRepositoryInterface $authorRepository) {}

    public function getAllActiveAuthors(): Collection
    {
        return $this->authorRepository->findActive();
    }

    public function getAuthorById(int $id): ?Author
    {
        return $this->authorRepository->findById($id);
    }

    public function createAuthor(array $data): Author
    {
        return $this->authorRepository->create($data);
    }

    public function updateAuthor(int $id, array $data): bool
    {
        return $this->authorRepository->update($id, $data);
    }

    public function deleteAuthor(int $id): bool
    {
        return $this->authorRepository->delete($id);
    }
}