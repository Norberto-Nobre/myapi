<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\TagRepositoryInterface;
use App\Contracts\PostRepositoryInterface;
use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use App\Repositories\PostRepository;
use App\Contracts\NewsletterServiceInterface;
use App\Contracts\NewsletterRepositoryInterface;
use App\Services\NewsletterService;
use App\Repositories\NewsletterRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(NewsletterServiceInterface::class, NewsletterService::class);
        $this->app->bind(NewsletterRepositoryInterface::class, NewsletterRepository::class);
    }

    public function boot(): void
    {
        //
    }
}