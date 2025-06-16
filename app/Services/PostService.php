<?php

namespace App\Services;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    public function __construct(protected PostRepositoryInterface $postRepository) {}

    public function getAllPublishedPosts(): Collection
    {
        return $this->postRepository->findPublished();
    }

    public function getPostBySlug(string $slug): ?Post
    {
        $post = $this->postRepository->findBySlug($slug);
        
        if ($post && $post->status === 'published') {
            $this->postRepository->incrementViews($post->id);
        }
        
        return $post;
    }

    public function getPostsByCategory(int $categoryId): Collection
    {
        return $this->postRepository->findByCategory($categoryId);
    }

    public function getPostsByAuthor(int $authorId): Collection
    {
        return $this->postRepository->findByAuthor($authorId);
    }

    public function getPostsByTag(int $tagId): Collection
    {
        return $this->postRepository->findByTag($tagId);
    }

    public function searchPosts(string $query): Collection
    {
        return $this->postRepository->search($query);
    }

    public function getPaginatedPosts(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->postRepository->paginate($perPage, $filters);
    }

    public function createPost(array $data): Post
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);
        return $this->postRepository->create($data);
    }

    public function updatePost(int $id, array $data): bool
    {
        if (isset($data['title'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
        }
        return $this->postRepository->update($id, $data);
    }

    public function deletePost(int $id): bool
    {
        return $this->postRepository->delete($id);
    }

    protected function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $slug = Str::slug($title);
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
        $query = Post::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}