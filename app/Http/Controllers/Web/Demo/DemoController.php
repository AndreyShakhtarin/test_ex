<?php

namespace App\Http\Controllers\Web\Demo;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Get;

class DemoController
{
    #[Get('/demo')]
    public function __invoke(): View
    {
        return view('demo', [
            'stats' => [
                'users' => User::count(),
                'categories' => Category::count(),
                'products' => Product::count(),
                'tags' => Tag::count(),
            ],
        ]);
    }
}
