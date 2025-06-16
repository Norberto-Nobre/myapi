<?php

namespace App\Services;

use App\Contracts\TagRepositoryInterface;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function __construct(protected TagRepositoryInterface $tagRepository) {}

    public function getAllActiveTags(): Collection
    {
        return $this->tagRepository->findActive();
    }

    public function getTagBySlug(string $slug): ?Tag
    {
        return $this->tagRepository->findBySlug($slug);
    }

    public function createTag(array $data): Tag
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        return $this->tagRepository->create($data);
    }

    public function updateTag(int $id, array $data): bool
    {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $id);
        }
        return $this->tagRepository->update($id, $data);
    }

    public function deleteTag(int $id): bool
    {
        return $this->tagRepository->delete($id);
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
        $query = Tag::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}