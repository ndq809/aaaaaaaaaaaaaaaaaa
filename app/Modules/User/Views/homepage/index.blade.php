@extends('layout')
@section('title','E+ Trang chủ')
@section('asset_header')
{!!WebFunctions::public_url('web-content/js/screen/homepage.js')!!}
{!!WebFunctions::public_url('web-content/css/screen/homepage.css')!!}
@stop
@section('left-tab')
@include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content border-left">
    <div class="col-xs-12 no-padding right-header no-fixed" data-target="#menu-body" data-toggle="collapse">
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
        <div class="col-md-12 collapse in no-padding open-when-small" id="menu-body">
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Học Từ Vựng
                    </h5>
                </div>
                <a href="/vocabulary">
                    <img src="web-content/images/background/option-background.png" width="100%" />
                </a>
                <div class="option-body" option-link="/vocabulary">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Đa dạng</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Nhiều chủ đề</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Cập nhật liên tục</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Dễ học dễ nhớ</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Hình ảnh,âm thanh</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Đóng góp ví dụ</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Học Ngữ Pháp
                    </h5>
                </div>
                <a href="/grammar">
                    <img src="web-content/images/background/option-background.png" width="100%" />
                </a>
                <div class="option-body" option-link="/grammar">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Chi tiết,dễ hiểu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Dễ dàng tra cứu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Hỗ trợ bài tập</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Đóng góp ví dụ</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Học Nghe
                    </h5>
                </div>
                <a href="/listening">
                    <img src="web-content/images/background/option-background.png" width="100%" />
                </a>
                <div class="option-body" option-link="/listening">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Nhiều mức độ</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Nhiều chủ đề</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Cập nhật liên tục</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Phân tách từng câu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Đánh giá từng câu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Danh sách từ mới</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Học Viết
                    </h5>
                </div>
                <a href="/writing">
                    <img src="web-content/images/background/option-background.png" width="100%" />
                </a>
                <div class="option-body" option-link="/writing">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Xem bài viết mẫu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Bố cục tùy chỉnh</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Gợi ý ngữ pháp</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Kiểm tra chính tả</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Đọc Hiểu
                    </h5>
                </div>
                <a href="/reading">
                    <img src="web-content/images/background/option-background.png" width="100%" />
                </a>
                <div class="option-body" option-link="/social">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Học theo đoạn văn</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Phân tách câu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Danh sách từ mới</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Bài tập tự luyện</h5>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-4 option">
                <div class="option-header">
                    <h5>
                        Từ Điển
                    </h5>
                </div>
                <a href="">
                    <img src="web-content/images/background/option-background.png" width="100%" />
                </a>
                <div class="option-body" option-link="/dictonary">
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Tra cứu nhanh</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Cập nhật liên tục</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Hình ảnh,âm thanh</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Xếp hạng ngữ nghĩa</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Lịch sử tra cứu</h5>
                    <h5 class="option-item"><i class="glyphicon glyphicon-flash"></i> Người dùng hỗ trợ</h5>
                </div>
            </div>
        </div>
        <div class='col-xs-12'>
            <div class='special-title'>
                ĐIỀU GÌ TẠO RA SỰ KHÁC BIỆT CHO EPLUS
            </div>
        </div>
        <div class='col-xs-12 margin-top margin-bottom'>
            <div class='special-box col-xs-12 margin-top'>
                <div class='special-content'>
                    <h4>Là 1 thế giới nơi việc học tiếng anh cũng như chơi game</h4>
                    <h4>Bạn có thể thực hiện nhiệm vụ, cày rank, ....</h4>
                    <h4>Nhiệm vụ đa dạng nhiều hạng mục tương ứng với các hạng mục của tiếng anh như nghe, nói, đọc, viết,...</h4>
                    <h4>Có cách tiếp cận với việc học tiếng anh mới lạ,thực tế</h4>
                    <h4>Nâng cao kiến thức thực tế cũng như kỹ năng đọc và trả lời với những câu hỏi ngẫu nhiên bằng tiếng anh</h4>
                    <h4>Đề cao sự trợ giúp của chính các bạn để hệ thống hoàn thiện hơn</h4>
                    <h4>Luôn cập nhật sửa đổi lắng nghe ý kiến của người dùng</h4>
                    <h4>Miễn phí và sẽ luôn như vậy <i class="fa fa-hand-peace-o"></i></h4>
                </div>
            </div>
        </div>
    </div>
    <div class=" col-xs-12 no-padding right-header no-fixed">
        <h5>
            <i class="glyphicon glyphicon-retweet">
            </i>
            Hôm nay có gì mới???
        </h5>
    </div>
    <div class="col-xs-12 no-padding" id="result">
        @include('User::homepage.search')
    </div>
</div>
@stop