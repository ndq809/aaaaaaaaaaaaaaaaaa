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
<div id="popup-box6" class="modal fade" role="dialog" tabindex='-1'>
    <div class="modal-dialog modal-lg">
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h5 class="modal-title">
                    KIỂM TRA TỪ VỰNG
                </h5>
            </div>
            <div class="modal-body" style="padding-top: 0px">
                <div class="form-group" min-width="1024px">
                    <div id="bonds" style="overflow: auto;"></div>
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