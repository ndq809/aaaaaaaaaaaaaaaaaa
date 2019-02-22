<div id="dtBox"></div>
<div id="popup-box0" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header login-modal">
                <button class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <div class="modal-title login-modal">
                    <span>ĐĂNG NHẬP E+</span>
                </div>
                <div class="login-with">
                    <a href="{{ route('facebook.login')}}"><i class="fa fa-facebook-official" title='Đăng nhập với facebook'></i></a>
                    <a href=""><i class="fa fa-twitter" title='Đăng nhập với twitter'></i></a> 
                    <a href=""><i class="fa fa-google-plus" title='Đăng nhập với google +'></i></a>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>
                        Tên Đăng Nhập
                    </label>
                    <div class="input-group">
                        <input class="form-control input-sm" id="account_nm" type="type" value="<?php if(isset($_COOKIE['account_nm'])){echo($_COOKIE['account_nm']); } ?>">
                        </input>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Mật Khẩu
                    </label>
                    <div class="input-group">
                        <input class="form-control input-sm" name="" type="password" id="password" value="<?php if(isset($_COOKIE['password'])){echo($_COOKIE['password']); } ?>">
                        </input>
                    </div>
                </div>
                <label class="checkbox-inline"><input type="checkbox" <?php if(isset($_COOKIE['remember_me'])){echo('checked'); } ?> tabindex="3" id="remember" maxlength="">Lưu mật khẩu đăng nhập</label>
                <span class="login-message hidden"></span>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger btn-sm float-left" href="/register">
                    Tạo Tài Khoản
                </a>
                <button class="btn btn-primary btn-sm" id="btn_login" type="button">
                    Đăng Nhập
                </button>
                <button class="btn btn-default btn-sm"  data-dismiss="modal" type="button">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>
<div id="popup-box1" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h5 class="modal-title">
                    BÀI TẬP VẬN DỤNG
                </h5>
            </div>
            <div class="modal-body" style="padding-top: 0px">
                <div class="form-group" min-width="1024px">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-refresh" type="button">
                    Làm mới câu hỏi
                </button>
                <button class="btn btn-danger btn-sm btn-check-answer" type="button">
                    Xem kết quả
                </button>
                <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>
<div id="popup-box2" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
         <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h5 class="modal-title">
                    BÁO CÁO BÀI VIẾT
                </h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>
                        Các Lỗi Vi Phạm
                    </label>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">Nội dung sai lệch</label>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="checkbox-inline"><inputradio-inline="checkbox" value="" checked="" id="vocal-image">Spam bài viết</label>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">Chứa nội dung phản động</label>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">xxx xxx xxx</label>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">xx xx xx xxxxxx </label>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">xxx x xxxxxx xxxxx</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Ghi chú thêm
                    </label>
                    <div class="input-group">
                       <textarea class="form-control input-sm" rows="2" ></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" data-dismiss="modal" type="button">
                    Gửi Báo Cáo
                </button>
                <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>
<div id="popup-box3" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h5 class="modal-title">
                    KẾT QUẢ BÀI NGHE
                </h5>
            </div>
            <div class="modal-body">
                <h5 class="result-text"></h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" data-dismiss="modal" type="button">
                    <i class="glyphicon glyphicon-thumbs-up"></i> Tiếp Tục Nghe 
                </button>
                <button class="btn btn-default btn-sm btn-show-answer" data-dismiss="modal" type="button">
                    <i class="glyphicon glyphicon-thumbs-down"></i> Xem Đáp Án
                </button>
            </div>
        </div>
    </div>
</div>
<div id="popup-box4" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h5 class="modal-title">
                    ĐĂNG KÝ NHIỆM VỤ
                </h5>
            </div>
            <div class="modal-body" style="padding: 0px 10px">
                <div class="row">
                    <div class="col-xs-12">
                        <label><span style="color: #009688;font-family: 'textfont';font-size: 20px">Nhiệm Vụ Từ Vựng</span></label>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <label>Danh Mục: <span style="color: #d9534f">600 từ vựng toleic</span></label>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <label>Nhóm: <span style="color: #d9534f">Business</span></label>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <label>Số từ cần phải học <span style="color: #d9534f">69</span></label>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <label>Điểm kinh nghiệm sẽ nhận được: <span style="color: #d9534f">2114</span></label>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Thời Gian</label>
                            <div class="input-group picker">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" name="" class="form-control input-sm" data-field="date" value="this is Datepicker" readonly="">
                                <span class="input-group-text">~</span>
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" name="" class="form-control input-sm" data-field="date" value="this is Datepicker" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Lịch Trình Mỗi Ngày</label>
                            <div class="input-group">
                                <select style="width: 100px" class="inline-block">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>15</option>
                                    <option>20</option>
                                </select>
                                <span class="input-group-text text-follow">(Mặc định là 5 từ vựng)</span>
                            </div>
                            <label class="text-danger"><span class="fa fa-exclamation-triangle"></span> Nếu không hoàn thành đkn nhận được sẽ bị trừ 1 điểm / 1 lần</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" data-dismiss="modal" type="button">
                     Xác Nhận 
                </button>
                <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>
<div id="popup-box5" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog">
         <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h5 class="modal-title">
                    LƯU BÀI DỊCH
                </h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <label class="radio-inline"><input type="radio" value="1" checked="" name="save-mode">Lưu như bài viết mới</label>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <label class="radio-inline"><input type="radio" value="2" name="save-mode">Lưu và đánh dấu đang dịch</label>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <label class="radio-inline"><input type="radio" value="3" name="save-mode">Lưu và đánh dấu đã dịch xong</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm btn-save" type="button">
                    Chấp Nhận
                </button>
                <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>