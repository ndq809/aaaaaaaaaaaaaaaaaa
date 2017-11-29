<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
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
        {!!WebFunctions::public_url('web-content/css/common/library/bootstrap.min.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/DateTimePicker.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/library/fileinput.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/common.css')!!}
        {!!WebFunctions::public_url('web-content/css/common/defined/screencontroller.css')!!}
        {!!WebFunctions::public_url('web-content/font-awesome-4.7.0/css/font-awesome.css')!!}
        @yield('asset_header')
    </head>
    <body>
        @include('popup')
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
                              <li role="presentation"><a role="menuitem" tabindex="-1" href="/master/g002">Trang Quản Trị</a></li>
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
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="col-xs-12 web-panel middle-content">
            <div class="col-lg-3 col-md-12 no-padding" style="padding-right: 1px;">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active col-sm-6 no-padding"><a data-toggle="tab" href="#sectionA" aria-expanded="true">Góc Học Tập</a></li>
                    <li class="col-sm-6 no-padding"><a data-toggle="tab" href="#sectionB" aria-expanded="false">Tin Tức Mới</a></li>
                </ul>
                <div class="tab-content">
                    <div id="sectionA" class="tab-pane fade active in">
                        <div class="left-header" data-target=".question" data-toggle="collapse">
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td width="90%">
                                            <h5>Nghĩa của từ "<span>Hello</span>" là gì?</h5>
                                        </td>
                                        <td class="collapse-icon" width="10%"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="collapse in question close-when-small">
                            <div class="left-content ">
                            <label class="radio-inline"><input type="radio" name="optradio">Thời tiết</label>
                            </div>
                            <div class="left-content ">
                                <label class="radio-inline"><input type="radio" name="optradio">Gia đình</label>
                            </div>
                            <div class="left-content ">
                                <label class="radio-inline"><input type="radio" name="optradio">Chào buổi sáng</label>
                            </div>
                            <div class="left-content ">
                                <label class="radio-inline"><input type="radio" name="optradio">Xin chào</label>
                            </div>
                            <button class="btn btn-sm btn-primary answer-btn " type="button">Trả Lời</button>
                            <div class="left-hint ">
                                <h6>Trả lời đúng mỗi câu được cộng 2 điểm sai bị trừ 1 điểm</h6>
                            </div>
                        </div>
                        <div class="left-header" data-target=".new-question" data-toggle="collapse">
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td width="95%">
                                            <h5>Đặt câu hỏi / Chủ đề mới</h5>
                                        </td>
                                        <td class="collapse-icon" width="5%"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="new-question collapse in close-when-small">
                            <label >Tiêu đề</label>
                            <textarea class="form-control input-sm" rows="2"></textarea>
                             <label >Nội dung</label>
                            <textarea class="form-control input-sm" rows="5"></textarea>
                            <button class="btn btn-sm btn-primary margin-top margin-bottom" type="button">Gửi Câu Hỏi</button>
                        </div>
                    </div>
                    <div id="sectionB" class="tab-pane fade">
                        <div class="left-header" data-target=".rank" data-toggle="collapse">
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td width="95%">
                                           <h5><span>Bảng Xếp Hạng Thành Viên</span></h5>
                                        </td>
                                        <td class="collapse-icon" width="5%"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="rank collapse in close-when-small">
                            <table class="table table-hover table-left">
                                <tbody>
                                    @for($i=1;$i<=5;$i++)
                                    <tr>
                                        <td width="70%">
                                            <label class="radio-inline"><img src="web-content/images/icon/rank/rank{{$i}}.png" width="25px">Quy Nguyen</label>
                                        </td>
                                        <td>
                                            <label class="radio-inline"><img src="web-content/images/icon/point.png" width="35px">10,000</label>
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="left-header" data-target=".news" data-toggle="collapse">
                            <table style="width: 100%">
                                <tbody>
                                    <tr>
                                        <td width="95%">
                                            <h5>Tin tức mới nhất</h5>
                                        </td>
                                        <td class="collapse-icon" width="5%"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="news collapse in close-when-small">
                            <table class="table table-hover table-center">
                                <tbody>
                                    @for($i=1;$i<=3;$i++)
                                    <tr>
                                        <td>
                                            <a>
                                                <i class="glyphicon glyphicon-hand-right">
                                                </i>
                                                Nhóm từ vựng
                                                <span>
                                                    Thiên nhiên
                                                </span>
                                                đã được thêm
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a>
                                                <i class="glyphicon glyphicon-hand-right">
                                                </i>
                                                Cập nhật ngữ pháp
                                                <span>
                                                    Trợ động từ
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12 no-padding change-content">
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
