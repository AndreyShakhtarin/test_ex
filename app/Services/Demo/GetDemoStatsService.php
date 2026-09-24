<?php

namespace App\Services\Demo;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class GetDemoStatsService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
        private readonly CategoryRepositoryInterface $categories,
        private readonly ProductRepositoryInterface $products,
        private readonly TagRepositoryInterface $tags,
    ) {}

    public function handle(): array
    {
        return [
            'users'      => $this->users->count(),
            'categories' => $this->categories->count(),
            'products'   => $this->products->count(),
            'tags'       => $this->tags->count(),
        ];
    }
}
