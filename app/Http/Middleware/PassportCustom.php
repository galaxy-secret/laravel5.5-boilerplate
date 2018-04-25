<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

/**
 * $provider = config('auth.guards.api.provider');
 * laravel passport 默认只获取 api 下的 provider，
 * 这里用中间件做一下改变，动态设置 auth.guards.api.provider 这个值
 * 使其支持多 provider 的 api 验证
 * Class PassportCustom
 * @package App\Http\Middleware
 * @author pandaria
 * @date 2018/4/24 18:30
 */
class PassportCustom
{

    protected $providers = [
        'members',
        'admin_users',
    ];

    /**
     * 目前暂未使用， 用户中心服务的话  可以使用这种方式
     * 目前是放到了 各个 登录注册的 controller 里了
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();
        if (array_key_exists('from', $params) && in_array($params['from'], $this->providers)) {
            Config::set('auth.guards.api.provider', $params['from']);
        }
        return $next($request);
    }
}
