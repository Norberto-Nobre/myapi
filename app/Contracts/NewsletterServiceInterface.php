<?php

namespace App\Contracts;

interface NewsletterServiceInterface
{
    public function subscribe(string $email): bool;
}