<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RootController extends Controller
{
    public function index(){
        if($input=Input::except('_token')){
            $rules = [
                'user_name'=>'required|between:5,15',
                'user_pass'=>'required|between:5,20|confirmed'
            ];
            $message = [
                'user_name.required'=>'账号不能为空',
                'user_name.between'=>'账号必须在5-15位之间',
                'user_pass.required'=>'密码不能为空',
                'user_pass.between'=>'密码必须在5-20位之间',
                'user_pass.confirmed'=>'密码和确认密码不一致',
            ];
            $validator = Validator::make($input,$rules,$message);
            if($validator->passes()){
                $input['user_pass'] = Crypt::encrypt($input['user_pass']);
                $res = User::create(['user_name'=>$input['user_name'],'user_pass'=>$input['user_pass']]);
                if($res){
                    return back()->with('errors','添加管理员成功');
                }else{
                    return back()->with('errors','添加管理员失败,请稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        return view('admin.root');
    }

}
