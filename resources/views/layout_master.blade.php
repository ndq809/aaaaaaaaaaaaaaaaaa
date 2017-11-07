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
                <nav class="navbar navbar-default ">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <span class="navbar-brand">
                                EPLUS
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
            <div class="change-content">
                @yield('content')
            </div>
            <div class="gw-sidebar">
              <div id="gw-sidebar" class="gw-sidebar">
                <div class="nano-content">
                  <ul class="gw-nav gw-nav-list">
                    <li class="init-un-active"> 
                        <a class="btn left-menu-btn"><i class="fa fa-reorder"></i></a>
                        <a> <span class="gw-menu-text">MENU QUẢN TRỊ</span> </a> 
                    </li>
                    <li > <a ><i class="fa fa-book"></i> <span class="gw-menu-text">Quản Lý Từ Vựng</span></a>
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
    </body>
</html>
