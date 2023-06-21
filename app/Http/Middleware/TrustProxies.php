<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request as R;

class TrustProxies extends Middleware
{
    protected $proxies;
    protected $headers =
        R::HEADER_X_FORWARDED_FOR |
        R::HEADER_X_FORWARDED_HOST |
        R::HEADER_X_FORWARDED_PORT |
        R::HEADER_X_FORWARDED_PROTO |
        R::HEADER_X_FORWARDED_AWS_ELB;
}
