<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/24 16:00
 */

namespace App\Traits\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

trait RegisterTraits {

    use AuthenticateClient;

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
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return $this->sendFailedRegisteredResponse($validator->errors()->toArray(), 401);
        }
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // 获取token
        $response = $this->authenticateClient($request);
        return $this->sendRegisteredResponse($user, json_decode($response->getContent(), true));
    }

    /**
     * @param $user
     * @param $token
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 16:23
     */
    protected function sendRegisteredResponse ($user, $token) {
        return $this->success(['data' => compact('token', 'user')], '注册成功');
    }

    /**
     * @param $errors
     * @param $code
     * @return mixed
     * @author pandaria
     * @date 2018/4/24 16:25
     */
    protected function sendFailedRegisteredResponse ($errors, $code) {
        return $this->failed(json_encode($errors), $code, $code);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:12',
            'email' => 'required|string|email|max:100|unique:' . $this->getGuardTableName(),
            'phone' => 'required|string|unique:' . $this->getGuardTableName(),
            'password' => 'required|string|min:6|confirmed',
            'head_pic' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return $this->getModelName()::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'head_pic' => $data['head_pic'],
        ]);
    }

}