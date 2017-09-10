<!DOCTYPE html>
<html>
<head>
    <title>跳转</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('static/css/index.css') }}" type="text/css" />
</head>
<body>
<section class="scrollable">
    <div class="text-center m-t-lg clearfix wrapper-lg animated fadeInRightBig" id="galleryLoading">
        <h1>{{$data['message']}}</h1>
        <h3 class="text-muted">
            等待
            <span class="loginTime">{{$data['jumpTime']}}</span>
            秒，页面自动跳转···
        </h3>
        <p class="m-t-lg"> <i class="fa fa-spinner fa fa-spin fa fa-2x"></i>
        </p >
    </div>
</section>
<script src="//cdn.bootcss.com/jquery/3.0.0-beta1/jquery.js"></script>
<script type="text/javascript">
        $(function(){
            var url = "{{$data['url']}}"
            var loginTime = parseInt($('.loginTime').text());
            var time = setInterval(function(){
                loginTime = loginTime-1;
                $('.loginTime').text(loginTime);
                if(loginTime==0){
                    clearInterval(time);
                    window.location.href=url;
                }
            },1000);
        })
    </script>
</body>
</html>