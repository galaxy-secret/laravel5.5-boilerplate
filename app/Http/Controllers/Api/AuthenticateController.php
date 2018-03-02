<?php

namespace App\Http\Controllers\Api;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Socialite;

use App\Models\User;
use App\Traits\Api\AuthenticateClient;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;

class AuthenticateController extends ApiController
{
	use AuthenticateClient;

    public function __construct()
    {
        $this->middleware('auth:api')->only([
            'logout'
        ]);
    }

    // 登录
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone'    => 'required|exists:users',
            'password' => 'required|between:5,32',
        ]);

        if ($validator->fails()) {
            $request->request->add([
                'errors' => $validator->errors()->toArray(),
                'code' => 401,
            ]);
            return $this->sendFailedLoginResponse($request);
        }
        $credentials = $this->credentials($request);

        if ($this->guard('api')->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        return $this->setStatusCode(401)->failed('登录失败');
    }

    // 退出登录
    public function logout(Request $request)
    {

        if (Auth::guard('api')->check()){
            Auth::guard('api')->user()->token()->revoke();
        }

        return $this->message('退出登录成功');

    }

    // 第三方登录
    public function redirectToProvider($driver) {

        if (!in_array($driver,['qq','wechat'])){

            throw new NotFoundHttpException;
        }

        return Socialite::driver($driver)->redirect();
    }

    // 第三方登录回调
    public function handleProviderCallback($driver) {

        $user = Socialite::driver($driver)->user();

        $openId = $user->id;

     // 第三方认证 third_party_type $driver
        $db_user = User::where([
                [ 'third_party_id', '=', $openId ],
                [ 'third_party_type', '=', $driver ],
            ])->first();

        if (empty($db_user)){

            $db_user = User::forceCreate([
                'phone' => '',
                'xxUnionId' => $openId,
                'nickname' => $user->nickname,
                'head' => $user->avatar,
            ]);

        }

        // 直接创建token

        $token = $db_user->createToken($openId)->accessToken;

        return $this->success(compact('token'));

    }

    protected function authenticated(Request $request)
    {
        return $this->authenticateClient($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        $response = $this->authenticated($request);
        $token = json_decode($response->getContent(), true);
        return $this->success(['message'=> "登录成功", 'token' => $token]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $msg = $request['errors'];
        $code = $request['code'];
        return $this->setStatusCode($code)->failed($msg);
    }


}
