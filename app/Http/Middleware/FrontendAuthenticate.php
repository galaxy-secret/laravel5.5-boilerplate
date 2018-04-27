<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class FrontendAuthenticate
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
        if (!check_frontend_user()){
            throw new AuthenticationException();
        }else {
            return $next($request);
        }
    }
}
