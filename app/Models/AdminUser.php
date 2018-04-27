<?php

namespace App\Models;

use App\Helpers\SoftDeleteByUnix\SoftDelete;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class AdminUser extends Authenticatable
{

    use HasApiTokens;
    use SoftDelete;

    protected $dateFormat = 'U';

    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','head_pic','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($username)
    {
        return self::where('phone', $username)->first();
    }
}
