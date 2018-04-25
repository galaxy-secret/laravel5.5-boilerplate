<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/10
 * Time: 17:38
 */

namespace App\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Traits\Api\ApiResponse;

class BaseController extends Controller
{

    use ApiResponse;

    protected $repo = null;

}