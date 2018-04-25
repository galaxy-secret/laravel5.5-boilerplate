<?php

namespace App\Models;

use App\Helpers\SoftDeleteByUnix\SoftDelete;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{

    use SoftDelete;
    protected $dateFormat = 'U';

}
