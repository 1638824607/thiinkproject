<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Message;
use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends CommonController
{
    public function index(){
        $mes_list = Message::orderBy('mes_time','desc')->paginate(10);
        return view('admin.message.list',compact('mes_list'));
    }
    public function show(){

    }
    public function destroy($mes_id){
        $res = Message::where('mes_id',$mes_id)->delete();
        if($res){
            $data = [
                'status' => 0,
                'msg' => '留言删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '留言删除失败！',
            ];

        }
        return $data;

    }
}
