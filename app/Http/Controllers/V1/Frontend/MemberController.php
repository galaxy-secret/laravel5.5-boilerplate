<?php

namespace App\Http\Controllers\V1\Frontend;

use App\Http\Controllers\V1\BaseController;
use App\Http\Resources\Frontend\MemberResource;
use Illuminate\Http\Request;

class MemberController extends BaseController
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $member = check_frontend_user();
        if (empty($member)) {
            return $this->notFond('User Not Found');
        }else {
            $resource = new MemberResource($member);
            return $this->success([ 'data' => $resource->jsonSerialize() ]);
        }
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
