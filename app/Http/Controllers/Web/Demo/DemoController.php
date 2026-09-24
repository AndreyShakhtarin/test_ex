<?php

namespace App\Http\Controllers\Web\Demo;

use App\Services\Demo\GetDemoStatsService;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Get;

class DemoController
{
    #[Get('/demo')]
    public function __invoke(GetDemoStatsService $service): View
    {
        return view('demo', ['stats' => $service->handle()]);
    }
}
