<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        <link rel="icon" type="image/x-icon" href="/web-content/images/icon/title_icon3.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <title>
            @yield('title','English Plus')
        </title>
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-3.2.1.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-ui.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-migrate-3.0.0.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery.mobile-events.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bootstrap.min.js')!!}
        <script src="//js.pusher.com/3.1/pusher.min.js"></script>
        {!!WebFunctions::public_url('web-content/js/common/defined/common.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/fileinput.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/DateTimePicker.js')!!}
        {!!WebFunctions::public_url('web-content/selectize/dist/js/standalone/selectize.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/liquidmetal.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery.rateit.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/loadingoverlay.js')!!}
        {!!WebFunctions::public_url('web-content/slider/dist/js/jquery.sliderPro.js')!!}
        {!!WebFunctions::public_url('web-content/slider/libs/fancybox/jquery.fancybox.js')!!}
        {!!WebFunctions::public_url('web-content/alert/dist/dev/jquery.sweet-modal.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/defined/message.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bootstrap.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/jquery-ui.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/DateTimePicker.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/selectize.bootstrap2.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/fileinput.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/animate.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/rateit.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/common.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/screencontroller.css')!!}
        {!!WebFunctions::public_url('web-content/font-awesome-4.7.0/css/font-awesome.css')!!}
        {!!WebFunctions::public_url('web-content/slider/dist/css/slider-pro.css')!!}
        {!!WebFunctions::public_url('web-content/slider/libs/fancybox/jquery.fancybox.css')!!}
        {!!WebFunctions::public_url('web-content/alert/dist/dev/jquery.sweet-modal.css')!!}
        {!!WebFunctions::public_url('web-content/ckeditor/ckeditor.js')!!}
        {!!WebFunctions::public_url('web-content/ckeditor/custom_config.js')!!}
        {!!WebFunctions::public_url('web-content/ckeditor/nanospell/autoload.js')!!}
        @yield('asset_header')
    </head>
    <body>
        @include('add_on')
        @include('comment')
        <input type="hidden" name="" id="check-error" value="{{isset(session('error')['status']) ? session('error')['status']: ''}}" param={{isset(session('error')['data'])? session('error')['data']: ''}}>
        <input type="hidden" name="" id="target-id" value="{{isset($data_default[2][0]['target_id'])?$data_default[2][0]['target_id']:''}}">
        <input type="hidden" name="" id="catalogue-tranfer" value="{{isset($data_default[2][0]['catalogue_tranfer'])?$data_default[2][0]['catalogue_tranfer']:''}}">
        <input type="hidden" name="" id="group-transfer" value="{{isset($data_default[2][0]['group_transfer'])?$data_default[2][0]['group_transfer']:''}}">
        <input type="hidden" name="" id="show_login" value="{{session('show_login')!==null?session('show_login'):''}}">
        <input type="hidden" name="" id="for_notify" value="{{isset(Auth::user()->account_id)?Auth::user()->account_id:''}}">
        <input type="hidden" name="" id="do-mission" value="{{session('mission')!=null&&session('mission')['link']==('/'.Request::path())?'1':'0'}}">
        @php(Session::forget('show_login'))
        <div class="my-progress"></div>
        <div class="body-content">
            <div class="col-xs-12 web-panel header-content">
                <div class="row top-header">
                    <div class="logo-box">
                        <div>
                            <span class="logo-box-text">ENGLISH</span>
                            <span class="logo-box-text "><span class="fa fa-graduation-cap logo-icon"></span> WORLD</span>
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
                                @if(isset(Auth::user()->account_nm))
                                <a class="navbar-brand dropdown-toggle" id="menu1" data-toggle="dropdown">
                                    <img src="
                                    {{ session::get('logined_data')[0]['avarta'] }}" height="30px" style="display: inline-block;border: 2px solid #eee;">
                                    <span>{{ Auth::user()->account_nm }}<i class="fa fa-angle-double-down" style="padding-left: 5px;vertical-align: middle;"></i></span>
                                </a>
                                <ul class="dropdown-menu user-menu" role="menu" aria-labelledby="menu1">
                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="/master">Trang Quản Trị</a></li>
                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="/profile">Trang Cá Nhân</a></li>
                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
                                  <li role="presentation" class="divider"></li>
                                  <li role="presentation"><a role="menuitem" tabindex="-1" id="btn-logout">Đăng Xuất</a></li>
                                </ul>
                                @else
                                <a class="navbar-brand btn-popup" popup-id="popup-box0">
                                    ĐĂNG NHẬP / ĐĂNG KÝ
                                </a>
                                @endif
                                 @if(session('mission')!=null&&session('mission')['link']==('/'.Request::path()))
                                <a class="navbar-brand" id="btn-cancel-mission">
                                    Hủy Nhiệm Vụ
                                </a>
                                @endif
                                <a class="btn btn-sm navbar-brand menu-btn" data-target="#menu" data-toggle="collapse">
                                    <i class="fa fa-reorder"></i>
                                </a>
                            </div>
                            <ul class="nav navbar-nav collapse in" id="menu">
                                <li>
                                    <a href="/">
                                        Trang Chủ
                                    </a>
                                </li>
                                <li>
                                    <a href="/vocabulary">
                                        Học Từ Vựng
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
                                    <a href="/reading">
                                        Đọc Hiểu
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="/social">
                                        Cộng Đồng E+
                                    </a>
                                </li> -->
                                <li>
                                    <a href="/dictionary">
                                        Từ Điển E+
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="/relax">
                                        Giải Trí
                                    </a>
                                </li> -->
                                <li>
                                    <a href="/translation">
                                        Dịch Thuật
                                    </a>
                                </li>
                                <li>
                                    <a href="/discuss">
                                        Hỏi Đáp
                                    </a>
                                </li>
                                <!-- <li>
                                    <a href="/contribute">
                                        Đóng Góp
                                    </a>
                                </li> -->
                                <!-- <li>
                                    <a id="post-face">
                                        Post face
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="col-xs-12 web-panel middle-content" >
                @yield('left-tab')
                @yield('content')
            </div>
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
