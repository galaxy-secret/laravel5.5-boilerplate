<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/19 16:17
 */


namespace App\Traits\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

trait AuthenticateClient {

    use AuthenticatesUsers;

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @author pandaria
     * @date 2018/4/24 15:45
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * 调用认证接口获取授权码
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 15:45
     */
    protected function authenticateClient(Request $request)
    {
        $credentials = $this->credentials($request);
        // 个人感觉通过.env配置太复杂，直接从数据库查更方便
        $password_client = Client::query()->where('password_client',1)->latest()->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $password_client->id,
            'client_secret' => $password_client->secret,
            'username' => $credentials[$this->username()],
            'password' => $credentials['password'],
            'scope' => '*'
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST',
            $request->all()
        );

        $response = Route::dispatch($proxy);

        return $response;
    }

    /**
     * 根据 refresh_token 来刷新 access_token
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author pandaria
     * @date 2018/4/25 15:00
     */
    protected function refreshTokenClient(Request $request)
    {
        // 个人感觉通过.env配置太复杂，直接从数据库查更方便
        $password_client = Client::query()->where('password_client',1)->latest()->first();
        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request['refresh_token'],
            'client_id' => $password_client->id,
            'client_secret' => $password_client->secret,
            'scope' => '*'
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST',
            $request->all()
        );

        $response = Route::dispatch($proxy);

        return $response;
    }

}