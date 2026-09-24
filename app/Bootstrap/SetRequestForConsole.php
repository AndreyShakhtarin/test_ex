<?php

namespace App\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class SetRequestForConsole
{
    public function bootstrap(Application $app): void
    {
        $uri = $app->make('config')->get('app.url', 'http://localhost');

        $components = parse_url($uri);

        $server = [
            'SCRIPT_FILENAME' => $components['path'] ?? '/',
            'SCRIPT_NAME'     => $components['path'] ?? '/',
        ];

        $app->instance('request', Request::create($uri, 'GET', [], [], [], $server));
    }
}
