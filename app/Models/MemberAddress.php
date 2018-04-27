<?php

namespace App\Models;


class MemberAddress extends Base
{

    protected $table = 'member_address';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'type', 'consignee','phone','province_id','province_name','city_id',
        'city_name', 'area_id', 'area_name', 'address', 'longitude', 'latitude', 'tag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
