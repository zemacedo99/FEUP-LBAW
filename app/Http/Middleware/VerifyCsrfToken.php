<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "/api/review",
        "/client/{id}/checkoutPayment",
        //
        '/api/coupon',
        '/api/coupon/*',
        '/api/client',
        '/api/client/*',
        '/api/item',
        '/api/item/*'
    ];
}