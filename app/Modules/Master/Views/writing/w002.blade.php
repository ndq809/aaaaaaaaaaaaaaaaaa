@extends('layout_master')
@section('title','Thêm Mới Bài Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/writing/w002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/writing/w002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-print','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/w001'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Nội Dung Thêm Mới</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Bài Viết</label>
                <select class="required">
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Danh Mục Của Bài Viết</label>
                <select class="required">
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Nhóm Của Bài Viết</label>
                <select class="required">
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Tiêu Đề Của Bài Viết</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm required" placeholder="Tên từ vựng">
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
            <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Nội Dung Bài Viết</label>
                <div class="input-group">
                    <textarea name="gra-content" class="form-control input-sm ckeditor required" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Danh Sách Đã Thêm</h5>
    </div>
    <div class="panel-content padding-10-l">
        <div class="table-fixed-width no-padding-left" min-width='768px'>
            <table class="table table-hover table-bordered table-checkbox table-new-row">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th>Tiêu Đề</th>
                        <th>Danh Mục</th>
                        <th>Nhóm</th>
                        <th>Tóm Tắt Nội Dung</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td>Abide by</td>
                        <td>Các thì trong tiếng anh</td>
                        <td>600 từ vựng toleic</td>
                        <td class="text-left">Người theo hương hoa mây mù giăng lối</td>
                    </tr>
                    @for($i=1;$i<=5;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td>Abide by</td>
                        <td>Các thì trong tiếng anh</td>
                        <td>600 từ vựng toleic</td>
                        <td class="text-left">Người theo hương hoa mây mù giăng lối</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop