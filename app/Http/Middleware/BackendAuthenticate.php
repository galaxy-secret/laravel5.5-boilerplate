<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class BackendAuthenticate
{
    /**
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     * @author pandaria
     * @date 2018/4/27 18:17
     */
    public function handle($request, Closure $next)
    {
        if (!check_backend_user()) {
            throw new AuthenticationException();
        }else {
            return $next($request);
        }
    }
}
