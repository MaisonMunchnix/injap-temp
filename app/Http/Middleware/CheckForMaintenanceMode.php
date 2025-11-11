<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CheckForMaintenanceMode extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        '/',
        'logout',
        'test2',
        //'staff*',
        //'login',
        'admin-login',
        'clear-cache',
        'bagsak_now',
        'bangon_now',
    ];
}
