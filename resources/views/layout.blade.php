<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        <link rel="shortcut icon" href="/web-content/images/icon/title-icon2.ico"/>
        <title>
            @yield('title','English Plus')
        </title>
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-3.2.1.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bootstrap.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/defined/common.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/fileinput.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/DateTimePicker.js')!!}
        {!!WebFunctions::public_url('web-content/selectize/dist/js/standalone/selectize.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/liquidmetal.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/loadingoverlay.js')!!}
        {!!WebFunctions::public_url('web-content/slider/dist/js/jquery.sliderPro.js')!!}
        {!!WebFunctions::public_url('web-content/slider/libs/fancybox/jquery.fancybox.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bootstrap.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/DateTimePicker.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/selectize.bootstrap2.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/fileinput.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/common.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/screencontroller.css')!!}
        {!!WebFunctions::public_url('web-content/font-awesome-4.7.0/css/font-awesome.css')!!}
        {!!WebFunctions::public_url('web-content/slider/dist/css/slider-pro.css')!!}
        {!!WebFunctions::public_url('web-content/slider/libs/fancybox/jquery.fancybox.css')!!}
        <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
        @yield('asset_header')
    </head>
    <body>
        @include('add_on')
        @include('comment')
        <div class="col-xs-12 web-panel header-content">
            <div class="row top-header">
                <div class="logo-box">
                    <div>
                        <span class="logo-box-text">ENGLISH</span>
                        <span class="logo-box-text "><span class="fa fa-graduation-cap logo-icon"></span> SOCIAL</span>
                    </div>
                    <div class="div-link" href="/">
                        <span class="logo-box-text1">EPLUS</span>
                    </div>
                </div>
                <div class="slogan-box">
                    <span class="text-slogan">COME HERE TO LEARN , PLAY AND EXPERIENCE</span>
                </div>
            </div>
            <div class="row top-header">
                <nav class="navbar navbar-default ">
                    <div class="container-fluid">
                        <div class="navbar-header hover-item">
                            @if(isset($user))
                            <a class="navbar-brand dropdown-toggle" id="menu1" data-toggle="dropdown">
                                <img src="/web-content/images/avarta/avarta.jpg" height="30px" style="display: inline-block;border: 2px solid #eee;">
                                <span>{{$user}}<i class="fa fa-angle-double-down" style="padding-left: 5px"></i></span>
                            </a>
                            <ul class="dropdown-menu user-menu" role="menu" aria-labelledby="menu1">
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="/master/p002">Trang Quản Trị</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="#">CSS</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
                              <li role="presentation" class="divider"></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="/">Đăng Xuất</a></li>
                            </ul>
                            @else
                            <a class="navbar-brand btn-popup" popup-id="popup-box0">
                                ĐĂNG NHẬP / ĐĂNG KÝ
                            </a>
                            @endif
                            <a class="btn btn-sm navbar-brand menu-btn" data-target="#menu" data-toggle="collapse">
                                <i class="fa fa-reorder"></i>
                            </a>
                        </div>
                        <ul class="nav navbar-nav collapse in" id="menu">
                            <li>
                                <a href="/">
                                    Trang chủ
                                </a>
                            </li>
                            <li>
                                <a href="/vocabulary">
                                    Học từ vựng
                                </a>
                            </li>
                            <li>
                                <a href="/grammar">
                                    Học Ngữ Pháp
                                </a>
                            </li>
                            <li>
                                <a href="/listening">
                                    Học Nghe
                                </a>
                            </li>
                            <li>
                                <a href="/writing">
                                    Học Viết
                                </a>
                            </li>
                            <li>
                                <a href="/social">
                                    Cộng Đồng E+
                                </a>
                            </li>
                            <li>
                                <a class="btn-popup" popup-id="popup-box1">
                                    Tra từ
                                điển
                                </a>
                            </li>
                            <li>
                                <a href="/relax">
                                    Giải trí
                                </a>
                            </li>
                            <li>
                                <a href="/contribute">
                                    Đóng góp
                                </a>
                            </li>
                            <li>
                                <a class="btn-popup" popup-id="popup-box4">
                                    Nhiệm vụ
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="col-xs-12 web-panel middle-content" >
            @yield('left-tab')
            @yield('content')
        </div>
        <div class="col-xs-12 no-padding bottom-content">
            <div class=" col-lg-3 col-sm-4 bottom-left">
                <span>Eplus</span>
                <span>©Eplus 2018 , all rights reserved</span>
                <span>Phiên bản : v2.0 - 2017/22/12</span>
                <span>Miễn Phí Và Sẽ Luôn Như Vậy <i class="fa fa-hand-peace-o"></i></span></span>
            </div>
            <div class="col-lg-7 col-sm-5 bottom-right ">
                <span class="block">Contact</span>
                <div class="inline-block">
                    <a><i class="fa fa-facebook-official"></i> Https://facebook.com/Eplus</a>
                </div>
                <div class="inline-block">
                    <a><i class="fa fa-google-plus"></i> Https://plus.google.com/Eplus</a>
                </div>
                <div class="inline-block">
                    <a><i class="fa fa-twitter"></i> Https://twitter.com/Eplus</a>
                </div>
                <div class="block"></div>
                <div class="inline-block">
                    <a><i class="fa fa-volume-control-phone"></i> +84 30 6969 69</a>
                </div>
                <div class="inline-block">
                    <a><i class="fa fa-envelope"></i> Eplus@gmail.com</a>
                </div>
            </div>
            <div class="col-lg-2 col-sm-3 bottom-right ">
                <span class="block">Infor</span>
                <div class="block">
                    <a>Birthday : 2016/09/08 <i class="fa fa-birthday-cake"></i></a>
                </div>
                <div class="block">
                    <a>Epluser : 1,183,547 <i class="fa fa-users"></i></a>
                </div>
                <div class="block">
                    <a>Privacy & Cookies <i class=" fa fa-legal"></i></a>
                </div>
            </div>
        </div>
    </body>
</html>
