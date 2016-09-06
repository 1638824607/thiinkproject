<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //友情链接列表
    public function index(){
        $data = Links::orderBy('link_order','desc')->get();
        return  view('admin.links.index',compact('data'));
    }
    public function changeOrder(){
        $input = Input::all();
        $links = Links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $res = $links->update();
        if($res){
            $data = [
                'status'=>0,
                'msg'   => '友情链接排序更新成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'   => '友情链接排序更新失败,请稍后重试!',
            ];
        }
        return $data;
    }
    public function show(){

    }
    //添加友情链接
    public function create(){
        return view('admin.links.add');
    }
    //友情链接提交
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required',
            'link_url'=>'required',
        ];
        $message = [
            'link_name.required'=>'链接名称不能为空',
            'link_url.required'=>'链接地址不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Links::create($input);
            if($res){
                return redirect('admin/links');
            }else{
                return back()->with('errors','链接填充失败,请稍后再试!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //更新链接
    public function update($link_id){
        $input = Input::except('_token','_method');
        $res = Links::where('link_id',$link_id)->update($input);
        if($res){
            return redirect('admin/links');
        }else{
            return back()->with('errors','友情链接更新失败,请稍后重试！');
        }
    }
    //编辑链接
    public function edit($link_id){
        $field = Links::find($link_id);
        return view('admin.links.edit',compact('field'));

    }
    public function destroy($link_id){
        $res = Links::where('link_id',$link_id)->delete();
        if($res){
            $data = [
                'status' => 0,
                'msg' => '友情链接删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接删除失败！',
            ];

        }
        return $data;
    }
}
