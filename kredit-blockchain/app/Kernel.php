<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Other middleware
    ];

    protected $middlewareGroups = [
        'web' => [
            // Other middleware
            \App\Http\Middleware\RestrictUnverifiedUser::class,
        ],
        'api' => [
            // API middleware
        ],
    ];

    protected $routeMiddleware = [
        // Other middleware
        'restrict.unverified' => \App\Http\Middleware\RestrictUnverifiedUser::class,
    ];
}
