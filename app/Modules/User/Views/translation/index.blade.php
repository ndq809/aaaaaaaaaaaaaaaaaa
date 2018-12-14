@extends('layout')
@section('title','E+ Dịch Thuật')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/translation.js')!!}
    {!!WebFunctions::public_url('web-content/compromise/builds/compromise.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.highlight-within-textarea.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/jquery.highlight-within-textarea.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/translation.css')!!}
@stop
@section('left-tab')
    @include('User::translation.left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
    <div class="temp hidden" style="height:27px"></div>
	<div class="right-header col-md-12 no-padding">
        <div class="col-md-12 no-padding">
            <table class="full-width">
                <tbody>
                    <tr>
                        <td class="text-center"><h5><i class="fa fa-language"></i> CÔNG CỤ DỊCH TIẾNG ANH</h5></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
     <div class="col-md-6 col-xs-12 right-tab" >
        <div class="form-group">
            <label class="inline-block">Nội Dung Tiếng Anh</label>
            <button class="btn btn-sm btn-default inline-block btn-fix" id="btn-clear" title="Xóa dữ liệu trên màn hình để nhập bản dịch mới">Làm mới</button>
            <button class="btn btn-sm btn-default inline-block btn-fix visible-sm visible-xs btn-extend" style="right: 75px">Thu nhỏ</button>
            <div class="default-background">
                <textarea class="form-control input-sm" id="en_text" rows="20" placeholder="Copy nội dung cần dịch của bạn vào"></textarea>
            </div>
        </div>
    </div>
     <div class="col-md-6 col-xs-12 right-tab" >
        <div class="form-group">
            <label class="inline-block">Nội Dung Đã Dịch</label>
            <button class="btn btn-sm btn-default inline-block btn-fix visible-sm visible-xs btn-extend" title="">Thu nhỏ</button>
            <div class="default-background">
            <textarea  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control input-sm" id="vi_text" rows="20" placeholder="Nội dung đã được dịch"></textarea>
        </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12 right-tab margin-top" >
        <div class="form-group">
            <label class="inline-block">Câu Cần Dịch</label>
            <button class="btn btn-sm btn-default inline-block btn-fix btn-delete" title="Xóa câu này trên nội dung" tabindex="-1">Xóa câu</button>
            <button class="btn btn-sm btn-default inline-block btn-fix btn-merge" title="Nối câu này với cầu trước nó thành 1 câu" tabindex="-1">Nối câu</button>
            <textarea class="form-control input-sm" id="en_sentence" rows="5" placeholder="Câu đang dịch (bạn có thể ngắt câu thành 2 câu ngắn hơn bằng phím enter tại 1 vị trí bất kỳ)"></textarea>
        </div>
        <div class="form-group btn-move margin-top" style="height: 31px">
            <button class="btn btn-sm btn-primary float-left" id="btn-prev" tabindex="-1">Câu Trước</button>
            <button class="btn btn-sm btn-primary float-right" id="btn-next" tabindex="-1">Câu Tiếp</button>
        </div>
        <div class="form-group">
            <label>Phân Tách Câu (Mang tính tương đối)</label>
            <div class="analysis" type = "1">
                <span>Danh Từ: </span>
                <span class="list"></span>
            </div>
            <div class="analysis" type = "2">
                <span>Động Từ: </span>
                <span class="list"></span>
            </div>
            <div class="analysis" type = "3">
                <span>Tính Từ: </span>
                <span class="list"></span>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12 right-tab margin-top" >
        <div class="form-group">
            <label class="inline-block">Nhập Bản Dịch</label>
            <button class="btn btn-sm btn-default inline-block btn-fix btn-delete" title="Xóa câu này trên nội dung" tabindex="-1">Xóa câu</button>
            <button class="btn btn-sm btn-default inline-block btn-fix btn-merge" title="Nối câu này với cầu trước nó thành 1 câu" tabindex="-1">Nối câu</button>
            <textarea  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control input-sm" id="vi_sentence" rows="5" placeholder="Nội dung đang dịch (bạn có thể ngắt câu thành 2 câu ngắn hơn bằng phím enter tại 1 vị trí bất kỳ)"></textarea>
        </div>
        <div class="form-group">
            <label class="inline-block">Bản Dịch Tự Động</label>
            <label class="checkbox-inline float-right"><input type="checkbox" id="auto-fill" checked="">Tự động thêm vào ô dịch</label>
            <textarea  autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control input-sm" id="auto_trans" rows="5" placeholder="Bản dịch tự động từ hệ thống (dùng để tham khảo)" disabled=""></textarea>
        </div>
    </div>
	
</div>

@stop

