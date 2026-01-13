<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;

class Authenticate extends MiddlewareAuthenticate
{
    /**
     * @param $request
     * @param array $guards
     * @return void
     * @throws AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        foreach ($guards as $guard) {
            switch ($guard) {
                case 'customer':
                    throw new AuthenticationException(redirectTo: route('frontend.index'));
                    break;
                default:
                    throw new AuthenticationException(redirectTo: route('login'));
            }
        }
    }
}
