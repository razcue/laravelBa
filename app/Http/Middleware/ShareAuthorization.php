<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

class ShareAuthorization
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        Inertia::share([
            'authorization' => [
                'user' => $request->user() ? $request->user()->only('id', 'name', 'email') : null,
                'can' => $request->user() ? $request->user()->getPermissionArray() : []
            ],
        ]);

        return $next($request);
    }
}
