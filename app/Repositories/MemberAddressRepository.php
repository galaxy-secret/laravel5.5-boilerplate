<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/25 16:26
 */

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class MemberAddressRepository extends Repository
{


    public function model()
    {
        return 'App\Models\MemberAddress';
    }


}