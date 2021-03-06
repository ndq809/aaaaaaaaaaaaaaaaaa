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
            @yield('title','English Plus Master')
        </title>
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-3.2.1.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-ui.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery-migrate-3.0.0.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/jquery.mobile-events.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bootstrap.min.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/autoresize.jquery.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/defined/common_master.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/defined/message.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/DateTimePicker.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/fileinput.js')!!}
        {!!WebFunctions::public_url('web-content/alert/dist/dev/jquery.sweet-modal.js')!!}
        {!!WebFunctions::public_url('web-content/slider/libs/fancybox/jquery.fancybox.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/croppic.js')!!}
        {!!WebFunctions::public_url('web-content/selectize/dist/js/standalone/selectize.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/liquidmetal.js')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/loadingoverlay.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bootstrap.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/DateTimePicker.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/jquery-ui.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/selectize.bootstrap2.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/fileinput.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/common_master.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/screencontroller_master.css')!!}
        {!!WebFunctions::public_url('web-content/font-awesome-4.7.0/css/font-awesome.css')!!}
        {!!WebFunctions::public_url('web-content/slider/libs/fancybox/jquery.fancybox.css')!!}
        {!!WebFunctions::public_url('web-content/js/common/library/bs_leftnavi.js')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/bs_leftnavi.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/croppic.css')!!}
        {!!WebFunctions::public_url('web-content/alert/dist/dev/jquery.sweet-modal.css')!!}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        {!!WebFunctions::public_url('web-content/ckeditor/ckeditor.js')!!}
        {!!WebFunctions::public_url('web-content/ckeditor/custom_config.js')!!}
        {!!WebFunctions::public_url('web-content/ckeditor/nanospell/autoload.js')!!}
        @yield('asset_header')
    </head>
    <body>
        <div id="dtBox"></div>
        <input type="hidden" name="" id="check-error" value="{{session('error')!==null ? session('error')['status']: ''}}">
        <div class="col-xs-12 web-panel header-content">
            <div class="row top-header">
                <nav class="navbar navbar-default ">
                    <div class="container-fluid">
                         <div class="navbar-header">
                            <a class="navbar-brand dropdown-toggle" id="menu1" data-toggle="dropdown">
                                <img src="{{ session::get('logined_data')[0]['avarta'] }}" height="30px">
                                <span>{{ Auth::user()->account_nm }}<i class="fa fa-angle-double-down" style="padding-left: 5px"></i></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="/?user=Quy Nguyen">Trang User</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="#">CSS</a></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="#">JavaScript</a></li>
                              <li role="presentation" class="divider"></li>
                              <li role="presentation"><a role="menuitem" tabindex="-1" id="btn-logout">Đăng Xuất</a></li>
                            </ul>
                        </div>
                        <ul class="nav menu-btn-mobile">
                           <li class="visible-xs">
                               <a class="btn-mobile"><span class="fa fa-reorder"></span></a>
                           </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="row top-header" style="margin-top: 42px;z-index: 400">
                <nav class="navbar navbar-default ">
                    <div class="container-fluid menu-btn-list">
                        <ul class="nav navbar-nav collapse in navbar-right" id="menu">
                            @yield('button')
                        </ul>
                         <ul class="nav navbar-nav screen-name">
                            @yield('title','English Plus Master')
                            <a class="btn btn-sm navbar-brand menu-btn hidden-md" data-target="#menu" data-toggle="collapse">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="col-xs-12 web-panel middle-content">
            <div class="change-content">
                @yield('content')
                <!-- <button type="button" onclick='swal("Good job!", "You clicked the button!", "warning");'>lalala</button> -->
            </div>
            @include('right_menu')
        </div>
        <div class="col-xs-12 no-padding bottom-content hidden">
            <h5 class="text-center">COPYRIGHT BY EPLUS.COM 2018 ALL RIGHTS RESERVED</h5>
        </div>
    </body>
</html>
