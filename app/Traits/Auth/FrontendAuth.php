<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/24 16:28
 */

namespace App\Traits\Auth;


trait FrontendAuth {

    public function getModelName()
    {
        return 'App\Models\Member';
    }

    public function getGuardTableName()
    {
        return 'members';
    }

    public function getGuard()
    {
        return 'api_frontend';
    }


}