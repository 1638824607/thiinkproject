@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类管理
    </div>
    <!--面包屑导航 结束-->
    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="#"><i class="fa fa-recycle"></i>全部分类</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr deep="{{$v->num}}">

                        <td class="tc">
                            <input type="text" name="ord[]" value="{{$v->cate_order}}" onchange="changeOrder(this,'{{$v->cate_id}}')">
                        </td>
                        <td class="tc">{{$v->cate_id}}</td>
                        <td>
                            <a href="" class="telescopic"><i class="fa fa-fw fa-minus-square"></i></a>{{$v->_cate_name}}
                        </td>

                        {{--fa-minus-square--}}
                        <td>{{$v->cate_title}}</td>
                        <td>{{$v->cate_view}}</td>
                        <td>
                            <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delCate({{$v->cate_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <script>
        $(function(){
            $('.telescopic').click(function(e){
                var currA = $(this);
                if(currA.find('i').eq(0).hasClass('fa-minus-square')){
                    var flag = 'minus';
                }else{
                    var flag = 'plus';
                }
                var currTr = $(this).parent().parent();
                currTr.nextAll('tr').each(function(i){
                    if(currTr.attr('deep')< $(this).attr('deep')){
                        if(flag == 'minus'){
                            $(this).hide();
                            currA.find('i').eq(0).removeClass('fa-minus-square').addClass('fa-plus-square');
                        }else if(flag == 'plus'){
                            $(this).show();
                            currA.find('i').eq(0).removeClass('fa-plus-square').addClass('fa-minus-square');
                        }
                    }else{
                        return false;
                    }
                });
                e.preventDefault();
            });
        });
    </script>
<script>
    function changeOrder(obj,cate_id){
        var cate_order = $(obj).val();
        $.post("{{url('admin/cate/changeOrder')}}",{'_token':'{{csrf_token()}}','cate_id':cate_id,'cate_order':cate_order},function(data){
            if(data.status==0){
                layer.msg(data.msg,{icon:6});
            }else{
                layer.msg(data.msg,{icon:5});
            }
        });
    }

    function delCate(cate_id){
        layer.confirm('您确定要删除这个分类吗?',{
            btn: ['确定','取消']
        },function(){
            $.post("{{url('admin/category/')}}/"+cate_id,{'_method':'delete','_token':"{{csrf_token()}}"},function(data){
                if(data['status']==0){
                    location.href = location.href;
                    layer.msg(data.msg,{icon:6});
                }else{
                    layer.msg(data.msg,{icon:5});
                }
            });
        },function(){
//            layer.msg('111',{
//                time: 20000,
//                btn: ['122','324']
//            });
        });
    }
</script>
@endsection