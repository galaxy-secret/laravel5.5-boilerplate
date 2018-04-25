<?php

namespace App\Http\Controllers\Auth\Frontend;

use App\Http\Controllers\V1\BaseController;
use App\Interfaces\Auth\RegisterInterface;
use App\Traits\Auth\FrontendAuth;
use App\Traits\Auth\RegisterTraits;
use Illuminate\Support\Facades\Config;

class RegisterController extends BaseController implements RegisterInterface
{
    use RegisterTraits;
    use FrontendAuth;

    public function __construct()
    {
        Config::set('auth.guards.api.provider', 'members');
        $this->middleware('guest');
    }

    public function username()
    {
        return 'phone';
    }

}
