@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;系统基本信息
    </div>
    <!--面包屑导航 结束-->
    <style>
        #div1 {
            position: absolute;
            top: 50px;
            right: 70px;
            float: right;
        }
    </style>
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h4>欢迎管理员 : {{session('user.user_name')}}</h4>
            现在北京时间 : <span id="timespan"></span>
        </div>
        <script>
            $(function(){
                //setInterval("$('#currentTime').text(new Date().toLocalsString());",1000);
                setInterval(function(){
                    $("#timespan").text(new Date().toLocaleString());
                },1000);
            });
        </script>
        <div id="div1">
            <img src="{{asset('resources/views/admin/style/img/shen.jpg')}}" alt="">
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>系统基本信息</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>操作系统</label><span>{{PHP_OS}}</span>
                </li>
                <li>
                    <label>运行环境</label><span>{{$_SERVER['SERVER_SOFTWARE']}}</span>
                </li>
                <li>
                    <label>PHP运行方式</label><span>LAMP</span>
                </li>
                <li>
                    <label>版本</label><span>v-0.1</span>
                </li>
                <li>
                    <label>上传附件限制</label><span><?php echo get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件" ?></span>
                </li>
                <li>
                    <label>北京时间</label><span><?php echo date("Y-m-d H:i:s") ?></span>
                </li>
                <li>
                    <label>服务器域名/IP</label><span>{{$_SERVER['SERVER_ADDR']}} {{$_SERVER['SERVER_NAME']}}</span>
                </li>
                <li>
                    <label>Host</label><span>{{$_SERVER['SERVER_ADDR']}}</span>
                </li>
            </ul>
        </div>
    </div>


    <div class="result_wrap">
        <div class="result_title">
            <h3>使用帮助</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>联系QQ：</label><span>1638824607</span>
                </li>
                <li>
                    <label>联系电话：</label><span>17180101405</span>
                </li>
            </ul>
        </div>
    </div>
    <!--结果集列表组件 结束-->
@endsection

