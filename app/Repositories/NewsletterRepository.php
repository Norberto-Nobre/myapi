<?php

namespace App\Repositories;

use App\Models\NewsletterEmail;

class NewsletterRepository
{
    public function create(array $data): NewsletterEmail
    {
        return NewsletterEmail::create($data);
    }
}