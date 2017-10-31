@extends('layout')
@section('title','E+ Trang chủ')
@section('asset_header')
   {!!WebFunctions::public_url('web-content/js/screen/homepage.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/homepage.css')!!}
@stop

@section('content')
<div class="col-xs-12 no-padding border-left">
    <div class="col-xs-12 no-padding right-header" data-target="#menu-body" data-toggle="collapse">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td width="95%">
                         <h5>
                            Chào mừng bạn đến với website
                            <span>
                                English Plus!!!
                            </span>
                            Hãy cùng chúng tôi trải nghiệm 1 môi trường tiếng anh thật sự
                            <i class="glyphicon glyphicon-fire">
                            </i>
                        </h5>
                    </td>
                    <td class="collapse-icon" width="5%"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class=" col-xs-12 no-padding right-content">
        <div class="col-md-12 collapse in no-padding" id="menu-body">
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Học Từ Vựng
                    </h5>
                </div>
                <a href="/vocabulary">
                    <img src="web-content/images/background/option-background.png" width="100%"/>
                </a>
                <div class="option-body" option-link="/vocabulary">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Đa dạng</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Nhiều chủ đề</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Cập nhật liên tục</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Giao diện trực quan</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Dễ học dễ nhớ</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Hỗ trợ hình ảnh</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Học Ngữ Pháp
                    </h5>
                </div>
                <a href="/grammar">
                    <img src="web-content/images/background/option-background.png" width="100%"/>
                </a>
                <div class="option-body" option-link="/grammar">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Chi tiết,dễ hiểu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Dễ dàng tra cứu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Ví dụ rõ ràng</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Giao diện trực quan</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Hỗ trợ bài tập</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Bình luận, trao đổi</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option" >
                <div class="option-header">
                    <h5>
                        Học Nghe
                    </h5>
                </div>
                <a href="/listening">
                    <img src="web-content/images/background/option-background.png" width="100%"/>
                </a>
                <div class="option-body" option-link="/listening">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Nhiều mức độ</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Nhiều chủ đề</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Cập nhật liên tục</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Giao diện trực quan</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Hỗ trợ đánh giá</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" style="opacity: 0"></i> kết quả nghe được</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option" >
                <div class="option-header">
                    <h5>
                        Học Viết
                    </h5>
                </div>
                <a href="/writing">
                    <img src="web-content/images/background/option-background.png" width="100%"/>
                </a>
                <div class="option-body" option-link="/writing">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Xem bài viết mẫu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Bố cục tùy chỉnh</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Giao diện trực quan</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Gợi ý ngữ pháp</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Kiểm tra chính tả</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Chia sẻ bài viết</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option" >
                <div class="option-header">
                    <h5>
                        Cộng Đồng E+
                    </h5>
                </div>
                <a href="/social">
                    <img src="web-content/images/background/option-background.png" width="100%"/>
                </a>
                <div class="option-body" option-link="/social">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Xem bài viết chia sẻ</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Đánh giá bài viết</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Góp ý thảo luận</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Theo dõi bài viết</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option" >
                <div class="option-header">
                    <h5>
                        Giải Trí
                    </h5>
                </div>
                <a href="">
                    <img src="web-content/images/background/option-background.png" width="100%"/>
                </a>
                <div class="option-body" option-link="/relax">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Nội dung tiếng anh</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Hình ảnh</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Video</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Truyện</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Chém gió,thảo luận</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash" ></i> Đóng góp bài viết</h5>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-xs-12 no-padding right-header">
        <h5>
            <i class="glyphicon glyphicon-retweet">
            </i>
            Hôm nay có gì mới???
        </h5>
    </div>
        <div class="col-md-6 col-sm-6 no-padding">
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
        <div class="col-md-6 col-sm-6 no-padding">
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
        <div class="col-lg-12">
            <ul class="pager">
                <li>
                    <a href="#">
                        Trang trước
                    </a>
                </li>
                <li>
                    <a href="#">
                        1
                    </a>
                </li>
                <li>
                    <a href="#">
                        2
                    </a>
                </li>
                <li>
                    <a href="#">
                        Trang tiếp
                    </a>
                </li>
            </ul>
        </div>
</div>
@stop
