<?php

namespace App\Services;

use App\Repositories\NewsletterRepository;

class NewsletterService
{
    public function __construct(protected NewsletterRepository $repository) {}

    public function subscribe(string $email): void
    {
        $this->repository->create(['email' => $email]);
    }
}