<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Model\Message;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function Index(){
        //点击量最高的6篇文章(博客推荐)
        $pics = Article::orderBy('art_view','desc')->take(6)->get();
        //图文列表5篇(分页)
        $data = Article::Join('category','article.cate_id','=','category.cate_id')->orderBy('art_time','desc')->paginate(4);

        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        //最新发布的8片文章
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        //友情链接
        $links = Links::orderBy('link_order','asc')->get();

        return view('home.index',compact('hot','new','pics','data','links'));
    }
    public function cate($cate_id){
        $field = Category::find($cate_id);
        //图文列表5篇(分页)
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        //文章查看次数的自增
        Category::where('cate_id',$cate_id)->increment('cate_view');
        //当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();
        return view('home.list',compact('field','data','submenu'));
    }
    public function article($art_id){
        //关联查询
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //文章查看次数的自增
        Article::where('art_id',$art_id)->increment('art_view');

        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('field','article','data'));
    }
    public function message(Request $request){
        $method = $request->method();
        if($method=='POST'){
            $input=Input::except('_token');
            $rules = [
                'mes_name'=>'required',
                'mes_content'=>'required',
            ];
            $message = [
                'mes_name.required'=>'昵称不能为空！',
                'mes_content.required'=>'内容不能为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $input['mes_time'] = time();
                $res = Message::create($input);
                if($res){
                    return redirect('/message');
                }else{
                    return back()->with('errors','评论发表失败,请稍后重试!');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        $mes_list = Message::orderBy('mes_time','desc')->paginate(5);
        return view('home.message',compact('mes_list'));
    }
}
