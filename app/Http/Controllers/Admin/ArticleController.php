<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //全部文章列表
    // public function index(){
    //     $cate = (new Category)->tree();
    //     $data = Article::orderBy('art_id','desct')->paginate(5);
    //     return view('admin.article.index',compact('data','cate'));

    // }
    //添加文章
    public function create(){
        $data = (new Category)->tree();
        return view('admin.article.add',compact('data'));
    }
    //添加文章提交
    public function store(){
        $input = Input::except('_token');
        $input['art_time'] = time();
        $rules = [
            'art_title'=>'required',
            'art_editor'=>'required',
            'art_content'=>'required',
        ];
        $message = [
            'art_title.required'=>'文章名称不能为空',
            'art_editor.required'=>'文章作者不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Article::create($input);
            if($res){
                return redirect('admin/article/search');
            }else{
                return back()->with('errors','数据填充失败,请稍后再试!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //编辑文章
    public function edit($art_id){
        $data = (new Category)->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('data','field'));
    }
    //更新文章
    public function update($art_id){
        $input = Input::except('_token','_method');
        $res = Article::where('art_id',$art_id)->update($input);
        if($res){
            return redirect('admin/article/search');
        }else{
            return back()->with('errors','文章信息更新失败,请稍后重试!');
        }
    }
    //删除文章
    public function destroy($art_id){
        $res = Article::where('art_id',$art_id)->delete($art_id);
        if($res){
            $data = [
                'status' => 0,
                'msg' => '文章删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '文章删除失败！',
            ];

        }
        return $data;
    }
    public function search(){
        $input = Input::except('_token');
        $where = [];
        $cate_id = '';
        $art_tag = '';
        $cate = (new Category)->tree();
        $flag = '0';
        if(count($input)>1){
            if($input['cate_id']=='0'){
                $where =['art_tag'=>$input['art_tag']];
            }else{
                $where =['cate_id'=>$input['cate_id'],'art_tag'=>$input['art_tag']];
            }
            $cate_id = $input['cate_id'];
            $art_tag = $input['art_tag'];
            $flag = '1';
            $data = Article::where($where)->orderBy('art_id','desc')->paginate(8);
            return view('admin.article.index',compact('data','cate','cate_id','art_tag','flag'));
        }
        $data = Article::orderBy('art_id','desc')->paginate(8);
        return view('admin.article.index',compact('data','cate','cate_id','art_tag','flag'));


    }
}
