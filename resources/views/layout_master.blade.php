<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token"/>
        <link rel="shortcut icon" href="/web-content/images/icon/title-icon2.ico"/>
        <title>
            @yield('title','English Plus Master')
        </title>
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-3.2.1.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bootstrap.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/defined/common_master.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/DateTimePicker.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bootstrap.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/DateTimePicker.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/common_master.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/screencontroller_master.css')!!}
        {!!WebFunctions::public_url('web-content/font-awesome-4.7.0/css/font-awesome.css')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bs_leftnavi.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bs_leftnavi.css')!!}
        @yield('asset_header')
    </head>
    <body>
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
                    <span class="text-slogan">WE CAN DO ENYTHING IF WE TRUST !</span>
                </div>
            </div>
            <div class="row top-header">
                <nav class="navbar navbar-default ">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <span class="navbar-brand">
                                CÁC PHÍM CHỨC NĂNG
                            </span>
                            <a class="btn btn-sm navbar-brand menu-btn" data-target="#menu" data-toggle="collapse">
                                <i class="fa fa-reorder"></i>
                            </a>
                        </div>
                        <ul class="nav navbar-nav collapse in" id="menu">
                            <li>
                                <a href="/">
                                    Xem danh sách
                                </a>
                            </li>
                            <li>
                                <a href="/vocabulary">
                                    Thêm mới
                                </a>
                            </li>
                            <li>
                                <a href="/grammar">
                                    Sửa chữa
                                </a>
                            </li>
                            <li>
                                <a href="/listening">
                                    Xóa
                                </a>
                            </li>
                            <li>
                                <a href="/writing">
                                    Tìm kiếm
                                </a>
                            </li>
                            <li>
                                <a href="/social">
                                    Xuất file
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="col-xs-12 web-panel middle-content">
            <div class="col-lg-2 col-md-3 col-xs-12 no-padding" style="padding-right: 1px;">
                <div class="gw-sidebar">
                  <div id="gw-sidebar" class="gw-sidebar">
                    <div class="nano-content">
                      <ul class="gw-nav gw-nav-list">
                        <li class="init-un-active"> <a> <span class="gw-menu-text">MENU QUẢN TRỊ</span> </a><a class="btn left-menu-btn"><i class="fa fa-reorder"></i></a> </li>
                        <li > <a ><i class="fa fa-book" style="float: right;"></i> <span class="gw-menu-text">Quản Lý Từ Vựng</span></a>
                          <ul class="gw-submenu">
                            <li> <a >Menu 1</a> </li>
                          </ul>
                        </li>
                        <li > <a ><i class="fa fa-bookmark"></i><span class="gw-menu-text"> Quản Lý Ngữ Pháp</span></a>
                          <ul class="gw-submenu">
                            <li> <a >Menu 1</a> </li>
                            <li> <a >Menu 2</a> </li>
                            <li> <a >Menu 3</a> </li>
                          </ul>
                        </li>
                        <li > <a ><i class=" fa fa-assistive-listening-systems"></i> <span class="gw-menu-text">Quản Lý Bài Nghe</span></a>
                          <ul class="gw-submenu">
                            <li> <a >Menu 1</a> </li>
                            <li> <a >Menu 2</a> </li>
                            <li> <a >Menu 3</a> </li>
                          </ul>
                        </li>
                        <li > <a><i class="fa fa-paint-brush"></i><span class="gw-menu-text"> Quản Lý Bài Viết</span></a>
                          <ul class="gw-submenu">
                            <li> <a >Menu 1</a> </li>
                            <li> <a >Menu 2</a> </li>
                            <li> <a >Menu 3</a> </li>
                          </ul>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-12 no-padding change-content">
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
