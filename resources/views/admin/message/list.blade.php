@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;留言板管理
    </div>
    <!--面包屑导航 结束-->
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>昵称</th>
                        <th>内容</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($mes_list as $m)
                    <tr>
                        <td class="tc">{{$m->mes_id}}</td>
                        <td>
                            <a href="#">{{$m->mes_name}}</a>
                        </td>
                        <td>{{$m->mes_content}}</td>
                        <td>{{date('Y-m-d',$m->mes_time)}}</td>
                        <td>
                            {{--<a href="{{url('admin/mes/'.$m->mes_id.'/edit')}}">修改</a>--}}
                            <a href="javascript:;" onclick="delMes({{$m->mes_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_list">
                    {!! $mes_list->render() !!}
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
        function delMes(mes_id){
            layer.confirm('您确定要删除这条留言吗?',{
                btn: ['确定','取消']
            },function(){
                $.post("{{url('admin/mes/')}}/"+mes_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
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