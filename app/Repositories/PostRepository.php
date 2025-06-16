<?php

namespace App\Repositories;

use App\Models\Post;
use App\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(protected Post $model) {}

    public function findAll(): Collection
    {
        return $this->model->with(['author', 'category', 'tags'])->get();
    }

    public function findById(int $id): ?Post
    {
        return $this->model->with(['author', 'category', 'tags'])->find($id);
    }

    public function findBySlug(string $slug): ?Post
    {
        return $this->model->with(['author', 'category', 'tags'])
                          ->where('slug', $slug)
                          ->first();
    }

    public function findPublished(): Collection
    {
        return $this->model->published()
                          ->active()
                          ->with(['author', 'category', 'tags'])
                          ->orderBy('published_at', 'desc')
                          ->get();
    }

    public function findByCategory(int $categoryId): Collection
    {
        return $this->model->published()
                          ->active()
                          ->where('category_id', $categoryId)
                          ->with(['author', 'category', 'tags'])
                          ->orderBy('published_at', 'desc')
                          ->get();
    }

    public function findByAuthor(int $authorId): Collection
    {
        return $this->model->published()
                          ->active()
                          ->where('author_id', $authorId)
                          ->with(['author', 'category', 'tags'])
                          ->orderBy('published_at', 'desc')
                          ->get();
    }

    public function findByTag(int $tagId): Collection
    {
        return $this->model->published()
                          ->active()
                          ->whereHas('tags', function ($query) use ($tagId) {
                              $query->where('tags.id', $tagId);
                          })
                          ->with(['author', 'category', 'tags'])
                          ->orderBy('published_at', 'desc')
                          ->get();
    }

    public function search(string $query): Collection
    {
        return $this->model->published()
                          ->active()
                          ->where(function ($q) use ($query) {
                              $q->where('title', 'like', "%{$query}%")
                                ->orWhere('excerpt', 'like', "%{$query}%")
                                ->orWhere('content', 'like', "%{$query}%");
                          })
                          ->with(['author', 'category', 'tags'])
                          ->orderBy('published_at', 'desc')
                          ->get();
    }

    public function create(array $data): Post
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $post = $this->findById($id);
        return $post ? $post->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $post = $this->findById($id);
        return $post ? $post->delete() : false;
    }

    public function incrementViews(int $id): bool
    {
        $post = $this->findById($id);
        return $post ? $post->increment('views_count') : false;
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->published()->active()->with(['author', 'category', 'tags']);

        if (isset($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (isset($filters['author'])) {
            $query->where('author_id', $filters['author']);
        }

        if (isset($filters['tag'])) {
            $query->whereHas('tags', function ($q) use ($filters) {
                $q->where('tags.id', $filters['tag']);
            });
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                  ->orWhere('excerpt', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('published_at', 'desc')->paginate($perPage);
    }
}
