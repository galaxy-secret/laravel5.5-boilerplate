<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/24 16:29
 */

namespace App\Traits\Auth;

trait BackendAuth {

    public function getGuardTableName()
    {
        return 'admin_users';
    }

    public function getModelName()
    {
        return 'App\Models\AdminUser';
    }

    public function getGuard()
    {
        return 'api_backend';
    }

}