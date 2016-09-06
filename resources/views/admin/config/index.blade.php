@extends('layouts/admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;配置项列表
    </div>
    <!--面包屑配置项 结束-->
    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>增加配置项</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>配置项列表</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>更新排序</a>
                </div>
                <div class="result_title">
                    @if(count($errors)>0)
                        <div class="mark">
                            @if(is_object($errors))
                                @foreach($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            @else
                                <p id="timep">{{$errors}}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>
    <script>
        $('.result_title').fadeOut(3000);
    </script>
    <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changecontent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>配置项标题</th>
                        <th>配置项名称</th>
                        <th>配置项内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" value="{{$v->conf_order}}" onchange="changeOrder(this,'{{$v->conf_id}}')">
                        <td class="tc">{{$v->conf_id}}</td>
                        <td>
                            <a href="#">{{$v->conf_title}}</a>
                        </td>
                        <td>{{$v->conf_name}}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$v->conf_id}}">
                            {!!$v->_html!!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delconfig({{$v->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                    <div class="btn_group">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </div>
                </form>
                <div class="page_list">
                    {{--{{$data->config()}}--}}
                </div>
            </div>
        </div>
    <style>
        .result_content ul li span{
            font-size: 15px;
            padding:6px 12px;
        }
    </style>
    <script>

        function changeOrder(obj,conf_id){
            var conf_order = $(obj).val();
            $.post("{{url('admin/config/changeOrder')}}",{'_token':'{{csrf_token()}}','conf_id':conf_id,'conf_order':conf_order},function(data){
                if(data.status==0){
                    layer.msg(data.msg,{icon:6});
                }else{
                    layer.msg(data.msg,{icon:5});
                }
            });
        }
        function delconfig(conf_id){
            layer.confirm('您确定要删除这个配置项吗?',{
                btn: ['确定','取消']
            },function(){
                $.post("{{url('admin/config/')}}/"+conf_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                    if(data['status']==0){
                        location.href = location.href;
                        layer.msg(data.msg,{icon:6});
                    }else{
                        layer.msg(data.msg,{icon:5});
                    }
                });
            },function(){
            });
        }
    </script>
@endsection