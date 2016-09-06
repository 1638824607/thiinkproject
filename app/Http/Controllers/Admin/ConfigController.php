<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //配置项列表
    public function index(){
        $data = Config::orderBy('conf_order','desc')->get();
        foreach($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea name="conf_content[]" id="" cols="30" rows="10">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    $c = '';
                    foreach($arr as $m=>$n){
                        $r = explode('|',$n);
                        if($v->conf_content == $r[0]){
                            $c = 'checked';
                        }
                        $str .= '<input type="radio" name="conf_content[]" '.$c.' value="'.$r[0].'">'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return  view('admin.config.index',compact('data'));
    }
    public function changeOrder(){
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $res = $config->update();
        if($res){
            $data = [
                'status'=>0,
                'msg'   => '配置项排序更新成功',
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'   => '配置项排序更新失败,请稍后重试!',
            ];
        }
        return $data;
    }
    public function show(){

    }
    //添加配置项
    public function create(){
        return view('admin.config.add');
    }
    //配置项提交
    public function store(){
        $input = Input::except('_token');
        $rules = [
            'conf_title'=>'required',
            'conf_name'=>'required',
        ];
        $message = [
            'conf_title.required'=>'配置项标题不能为空',
            'conf_name.required'=>'配置项名称不能为空',
        ];
        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Config::create($input);
            if($res){
                return redirect('admin/config');
            }else{
                return back()->with('errors','配置项填充失败,请稍后再试!');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //更新链接
    public function update($conf_id){
        $input = Input::except('_token','_method');
        $res = config::where('conf_id',$conf_id)->update($input);
        if($res){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->with('errors','配置项更新失败,请稍后重试！');
        }
    }
    //编辑链接
    public function edit($conf_id){
        $field = config::find($conf_id);
        return view('admin.config.edit',compact('field'));

    }
    public function destroy($conf_id){
        $res = config::where('conf_id',$conf_id)->delete();
        if($res){
            $this->putFile();
            $data = [
                'status' => 0,
                'msg' => '配置项删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项删除失败！',
            ];

        }
        return $data;
    }
    public function changeContent(){
        $input = Input::all();
        foreach($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置项更新成功!');
    }
    public function putFile(){
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '. var_export($config,true).';';
        file_put_contents($path,$str);
    }
}
