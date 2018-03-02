<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

use App\Models\User;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class IndexController extends ApiController
{

    public function index(){
    	// return Auth::guard('api')->user();
        return new UserCollection(User::paginate(Input::get('limit') ?: 20));
    }

}
