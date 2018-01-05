<?php

namespace App\Http\Controllers\Api;

use App\AppSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AppController extends ResponseController
{
    /**
     * Get App Setting
     *
     * @return mixed
     */
    public function getSetting(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails())
            return $this->responseWithError($validator->errors()->first());
        return $this->response([
            'code'   => 200,
            'setting' => AppSetting::where('user_id',$request->user_id)->get()
        ]);
    }
}
