<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/24 16:00
 */

namespace App\Traits\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait LoginTraits {

    use AuthenticateClient;

    /**
     * @return array
     * @author pandaria
     * @date 2018/4/24 15:44
     */
    protected function validatorRules() {
        return [
            $this->username() => 'required|exists:' . $this->getGuardTableName(),
            'password' => 'required|between:6,32',
        ];
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard($this->getGuard());
    }

    /**
     * 登录方法
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author pandaria
     * @date 2018/4/25 13:02
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validatorRules());
        if ($validator->fails()) {
            return $this->sendFailedLoginResponse($validator->errors()->toArray(), 401);
        }
        $credentials = $this->credentials($request);

        if (Auth::guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }
        return $this->failed('登录失败', 401, 401);
    }

    /**
     * 退出登录
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 15:44
     */
    public function logout(Request $request)
    {
        if (Auth::guard($this->getGuard())->check()){
            Auth::guard($this->getGuard())->user()->token()->revoke();
        }
        return $this->success([], '退出登录成功');
    }


    /**
     * 第三方登录
     * @param $driver
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 15:44
     */
    public function redirectToProvider($driver) {
        if (!in_array($driver,['qq','wechat'])){
            throw new NotFoundHttpException();
        }
        return Socialite::driver($driver)->redirect();
    }
    //

    /**
     * 第三方登录回调
     * @param $driver
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 15:44
     */
    public function handleProviderCallback($driver) {
        $user = Socialite::driver($driver)->user();
        $openId = $user->id;
        // 第三方认证 third_party_type $driver
        $db_user = $this->getModelName()::where([
            [ 'third_party_id', '=', $openId ],
            [ 'third_party_type', '=', $driver ],
        ])->first();
        if (empty($db_user)){
            $db_user = $this->getModelName()::forceCreate([
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 15:44
     */
    protected function authenticated(Request $request)
    {
        return $this->authenticateClient($request);
    }

    /**
     * @param $errors
     * @param $code
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 16:25
     */
    protected function sendFailedLoginResponse ($errors, $code) {
        return $this->failed(json_encode($errors), $code, $code);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 15:44
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        $response = $this->authenticated($request);
        $token = json_decode($response->getContent(), true);
        return $this->success([ 'data' => compact('token') ], '登录成功');
    }

    /**
     * 刷新 token
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author pandaria
     * @date 2018/4/25 15:11
     */
    public function refreshToken(Request $request)
    {
        if (!check_user_stateful($this->getGuard())){
            // 如果用户未登录 request 中没有 access_token 或者是 access_token 过期
            // 要检查一下用户名密码(相当于走一遍登录流程)
            return $this->login($request);
        }else{
             // 正常登录状态下 刷新token
            $response = $this->refreshTokenClient($request);
            $token = json_decode($response->getContent(), true);
            return $this->success([ 'data' => compact('token') ], '登录成功');
        }
    }
}