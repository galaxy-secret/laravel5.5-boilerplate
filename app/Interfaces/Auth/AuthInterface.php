<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/24 15:52
 */

namespace App\Interfaces\Auth;

interface AuthInterface{

    public function username();
    public function getModelName();
    public function getGuard();
    public function getGuardTableName();

}