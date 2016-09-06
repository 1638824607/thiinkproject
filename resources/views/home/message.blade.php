@extends('layouts.home')
@section('info')
    <title>留言板-{{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
@endsection
@section('content')
<article class="blogs">
    <h1 class="t_nav"><span>欢迎网友发表自己的意见及看法,我们会仔细审阅并加以改进。</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('/message')}}" class="n2">留言板</a></h1>
    <div class="newblog left">
            {{--<h2>姓名：2:3321</h2>--}}
        @foreach($mes_list as $mes)
            <p class="dateview"><span>　发布时间：{{date('Y-m-d H:i:s',$mes['mes_time'])}}</span><span>游客：{{$mes['mes_name']}}</span></p>
            <figure></figure>
            <ul class="nlist">
                <p>{{$mes['mes_content']}}</p>
                {{--<a title="12321321" href="" target="_blank" class="readmore">阅读全文>></a>--}}
            </ul>
            <div class="line"></div>
        <div class="blank"></div>
        @endforeach
        <div class="page">
            {{$mes_list->links()}}
        </div>
        <div class="line"></div>
        <div class="blank"></div>
        <div class="ad">
            <h4>请留下的您的意见和评论！</h4><br>
            <form action="{{url('/message')}}" method="post">
                {{csrf_field()}}
                <span>昵称：</span><input type="text" name="mes_name" maxlength="10"><span style="font-size: 12px"><i class="fa fa-exclamation-circle yellow"></i>昵称长度不能超过10位</span><br><br>
                <textarea name="mes_content" id="" cols="10" rows="10"></textarea>
                @if(count($errors)>0)
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <span class="mark">{{$error}}</span>
                            @endforeach
                        @else
                            <span class="mark">{{$errors}}</span>
                        @endif
                @endif
                <div style="float: right;margin-right: 137px">
                    <input type="submit" value="提交">
                    <input type="reset" class="back" value="取消">
                </div>
            </form>
        </div>
        <div class="page">
            {{--{{$data->links()}}--}}
        </div>
    </div>
    <aside class="right">
        <!-- Baidu Button BEGIN -->
            {{--<h3 class="ph">--}}
                {{--<p>博客<span>分享</span></p>--}}
            {{--</h3>--}}
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
        <div class="news">
            @parent
        </div>
    </aside>
</article>
<style>
    input[type='reset']{
        padding:0 25px;  height:25px;  vertical-align:middle;  margin-right:10px;  color:#666;  letter-spacing:2px;  border-radius:3px;  background:#f0f0f0;  border:1px solid #ccc;  cursor:pointer
    }
    .mark{
        font-size: 12px;
        color: #ff0000;
    }
</style>
<script>
    $('.mark').fadeOut(3000);
</script>
@endsection
