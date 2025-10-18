<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'stripe/*',
        'stripe/webhook',
        '/stripe/webhook',
    ];

    // Temporary: Always skip CSRF for webhook testing
    public function handle($request, Closure $next)
    {
        if ($request->is('stripe/webhook') || $request->is('stripe/*')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
