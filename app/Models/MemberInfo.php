<?php

namespace App\Models;


class MemberInfo extends Base
{

    protected $table = 'member_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'sex', 'age','identity_card',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
