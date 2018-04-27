<?php

namespace App\Http\Controllers;

use App\Http\Controllers\V1\BaseController;
use App\Models\AdminUser;
use App\Models\Member;
use App\Utils\GnuPG\GnuPG;
use App\Utils\GnuPG\GnuPGConfig;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

use App\Utils\Eleme\ElemeClient;
use App\Utils\Eleme\ElemeConfig;
use Illuminate\Support\Facades\Auth;

class TestController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $eleme = new ElemeClient(new  ElemeConfig());
//        $sign_array = [];
//        $sign_array['cart_id'] = 123;
//        $sign_array['ip'] = '192.168.1.1';
//        $sign_array['is_online_paid'] = true;
//        $sign_array['phones'] = '13659845975';
//        $sign_array['total'] = '25.68';
//        $sign_array['tp_order_id'] = '1346546safae68464sge8';
//        $signature = $eleme->orderSignature($sign_array);
//        dump($signature);
//        dump(pack('H*', $signature));
//        dump($eleme->verifyOrderSignature($sign_array, $signature));


//        $gpg = new GnuPG(new GnuPGConfig());
//        $encrypt_sign = $gpg->encrypt('this is a text');
//        dump($encrypt_sign);
//        dump($gpg->decrypt($encrypt_sign));

//        $member = Member::all();
//        dump(Member::withoutTrashed()->get());

//        dump(Auth::guard('api_frontend')->user()->toJson());
//        dump(Auth::guard('api_frontend')->id());

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
