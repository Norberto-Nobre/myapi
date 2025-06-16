<?php

namespace App\Services;

use App\Contracts\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(protected CategoryRepositoryInterface $categoryRepository) {}

    public function getAllActiveCategories(): Collection
    {
        return $this->categoryRepository->findActive();
    }

    public function getCategoryBySlug(string $slug): ?Category
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function createCategory(array $data): Category
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data): bool
    {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $id);
        }
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }

    protected function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = Category::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}