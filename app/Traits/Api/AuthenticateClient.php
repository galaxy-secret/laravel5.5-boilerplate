<?php
/**
 * 
 * @authors Your Name (you@example.org)
 * @date    2018-02-27 09:57:14
 * @version $Id$
 */


namespace App\Traits\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

trait AuthenticateClient {

    use AuthenticatesUsers;

    public function username()
    {
        return 'phone';
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

	//调用认证接口获取授权码
    protected function authenticateClient(Request $request)
    {
        $credentials = $this->credentials($request);

            // 个人感觉通过.env配置太复杂，直接从数据库查更方便
        $password_client = Client::query()->where('password_client',1)->latest()->first();

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $password_client->id,
            'client_secret' => $password_client->secret,
            'username' => $request['phone'],
            'password' => $request['password'],
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = \Route::dispatch($proxy);

        return $response;
    }



}