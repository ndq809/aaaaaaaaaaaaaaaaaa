<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        <link rel="shortcut icon" href="/web-content/images/icon/title-icon2.ico"/>
        <title>
            @yield('title','Không Tìm Thấy Trang')
        </title>
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-3.2.1.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-migrate-3.0.0.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery.mobile-events.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bootstrap.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/defined/common_master.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/DateTimePicker.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/fileinput.js')!!}
        {!!WebFunctions::public_url('web-content/slider/libs/fancybox/jquery.fancybox.js')!!}
        {!!WebFunctions::public_url('web-content/alert/dist/dev/jquery.sweet-modal.js')!!}
        {!!WebFunctions::public_url('web-content/selectize/dist/js/standalone/selectize.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/liquidmetal.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/loadingoverlay.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bootstrap.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/DateTimePicker.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/selectize.bootstrap2.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/fileinput.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/common_master.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/screencontroller_master.css')!!}
        {!!WebFunctions::public_url('web-content/font-awesome-4.7.0/css/font-awesome.css')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bs_leftnavi.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bs_leftnavi.css')!!}
        {!!WebFunctions::public_url('web-content/alert/dist/dev/jquery.sweet-modal.css')!!}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                if(window.location.href.split('/')[3]==='master'){
                    $(".back-home").attr('href','/master/general/g001');
                }else{
                    $(".back-home").attr('href','/');
                }
            });
        </script>

    </head>
    <body>
        <div class="col-xs-12 web-panel header-content" style="text-align: center;">
            <div class="login-wrap" style="width: 100%">
                <div class="logo-box" >
                    <div>
                        <span class="logo-box-text">ENGLISH</span>
                        <span class="logo-box-text "><span class="fa fa-graduation-cap logo-icon"></span> SOCIAL</span>
                    </div>
                    <div class="div-link" href="/">
                        <span class="logo-box-text1">EPLUS</span>
                    </div>
                </div>
                <div class="slogan-box">
                    <span class="text-slogan">LEARN , PLAY AND EXPERIENCE</span>
                </div>
                <div class="login-form" style="margin: 0 auto;padding: 0px 10px;">
                    <img class="not-found" src="/web-content/images/icon/404.png">
                    <div class="text-center">
                        <a href="/master/general/g001" class="fa fa-hand-o-right back-home" style="font-size: 20px;text-decoration: underline;"><span style="font-family: textfont"> Quay Lại Trang Chủ</span> </a>
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>
</html>
