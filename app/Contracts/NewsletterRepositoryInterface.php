<?php

namespace App\Contracts;

use App\Models\NewsletterEmail;

interface NewsletterRepositoryInterface
{
    public function save(string $email): NewsletterEmail;
    public function exists(string $email): bool;
}