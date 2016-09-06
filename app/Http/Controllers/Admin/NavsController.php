<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    //自定义导航列表
    public function index(){
        $data = Navs::orderBy('nav_order','desc')->get();
        return  view('admin.navs.index',compact('data'));
    }
    public function changeOrder(){
        $input = Input::all();
        $navs = navs::find($input['nav_id']);
        $navs->nav_order = $input['nav_order'];
        $res = $navs->update();
        if($res){
            $data = [
                'status'=>0,
                'msg'   => '自定义导航排序更新成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'   => '自定义导航排序更新失败,请稍后重试!',
            ];
        }
        return $data;
    }
    public function show(){

    }
    //添加自定义导航
    public function create(){
        return view('admin.navs.add');
    }
    //自定义导航提交
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'nav_name'=>'required',
            'nav_url'=>'required',
        ];
        $message = [
            'nav_name.required'=>'导航名称不能为空',
            'nav_url.required'=>'导航地址不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = navs::create($input);
            if($res){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','自定义导航填充失败,请稍后再试!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //更新链接
    public function update($nav_id){
        $input = Input::except('_token','_method');
        $res = navs::where('nav_id',$nav_id)->update($input);
        if($res){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','自定义导航更新失败,请稍后重试！');
        }
    }
    //编辑链接
    public function edit($nav_id){
        $field = navs::find($nav_id);
        return view('admin.navs.edit',compact('field'));

    }
    public function destroy($nav_id){
        $res = navs::where('nav_id',$nav_id)->delete();
        if($res){
            $data = [
                'status' => 0,
                'msg' => '自定义导航删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '自定义导航删除失败！',
            ];

        }
        return $data;
    }
}
