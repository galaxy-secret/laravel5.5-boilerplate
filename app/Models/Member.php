<?php

namespace App\Models;

use App\Helpers\SoftDeleteByUnix\SoftDelete;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens;
    use SoftDelete;
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'U';
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','head_pic','status','sn'
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
