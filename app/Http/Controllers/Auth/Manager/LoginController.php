<?php

namespace App\Http\Controllers\Auth\Manager;

use App\Http\Controllers\V1\BaseController;
use App\Interfaces\Auth\LoginInterface;
use App\Traits\Auth\BackendAuth;
use App\Traits\Auth\LoginTraits;
use Illuminate\Support\Facades\Config;

class LoginController extends  BaseController implements LoginInterface
{
    use LoginTraits;
    use BackendAuth;

    public function __construct()
    {
        /**
         * Auth::guard()->attempt()
         * 默认获得 sessionGuard 即默认使用的是 web-guard ,这里动态将其 provider 修改为相应的值
         */
        Config::set('auth.guards.web.provider', 'admin_users');
        Config::set('auth.guards.api.provider', 'admin_users');
        $this->middleware('auth:api')->only([
            'logout'
        ]);
    }

    public function username()
    {
        return 'phone';
    }
}
