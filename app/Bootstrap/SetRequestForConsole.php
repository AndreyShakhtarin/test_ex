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

        // Railway can inject env vars with malformed URIs or IPv6 hosts; fall back safely.
        if ($components === false || (isset($components['host']) && !$this->isHostValid($components['host']))) {
            $uri = 'http://localhost';
            $components = ['path' => '/'];
        }

        $server = [
            'SCRIPT_FILENAME' => $components['path'] ?? '/',
            'SCRIPT_NAME'     => $components['path'] ?? '/',
        ];

        try {
            $app->instance('request', Request::create($uri, 'GET', [], [], [], $server));
        } catch (\Throwable) {
            $app->instance('request', Request::create('http://localhost', 'GET', [], [], [], $server));
        }
    }

    private function isHostValid(string $host): bool
    {
        if ('[' === $host[0]) {
            return ']' === $host[-1] && filter_var(substr($host, 1, -1), \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6);
        }

        if (preg_match('/\.[0-9]++\.?$/D', $host)) {
            return null !== filter_var($host, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4 | \FILTER_NULL_ON_FAILURE);
        }

        return '' === preg_replace('/[-a-zA-Z0-9_]++\.?/', '', $host);
    }
}
