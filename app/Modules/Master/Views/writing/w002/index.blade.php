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
    <div class="panel-content no-padding-left update-block">
         <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Bài Viết</label>
                <div class="input-group">
                    <input id="post_id" type="text" name="" class="form-control input-sm identity-item" placeholder="Trường hệ thống tự sinh ra" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                 <select class="allow-selectize required submit-item" id="catalogue_div">
                     @foreach($data[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <select class="submit-item allow-selectize required" id="catalogue_nm">
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Nhóm</label>
                <select id="group_nm" class="submit-item allow-selectize required">
                        <option value=""></option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Tiêu Đề Của Bài Viết</label>
                <div class="input-group">
                    <input type="text" id="post_title" name="" class="form-control input-sm required submit-item" placeholder="Tiêu đề bài viết">
                </div>
            </div>
        </div>
        <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
            <div class="col-lg-3 col-md-3 col-sm-4 no-padding-right transform-content" transform-div='3'>
                <div class="form-group">
                    <label>Âm thanh</label>
                    <div class="input-group audio-custom-cover">
                        <input type="file" id="post_media" name="post_media1" class="input-audio" placeholder="ID của từ vựng">
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-10 no-padding-right transform-content" transform-div='7'>
                <div class="form-group">
                    <label>Hình Ảnh</label>
                    <div class="input-group image-custom-cover-w">
                        <input type="file" id="post_media" class="input-image-custom" name="post_media2"  value="">
                    </div>
                </div>
            </div>
        </form>
        <div class="col-md-12 col-sm-12 no-padding-right transform-content" transform-div='8'>
            <div class="form-group">
                <label>Link video</label>
                <div class="input-group">
                    <input type="text" id="post_media" class="input-sm form-control submit-item" name="">
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Nội Dung Bài Viết</label>
                <div class="input-group">
                    <textarea name="gra-content" id="post_content" class="form-control input-sm ckeditor submit-item" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group table-fixed-width" min-width="768px">
                <label>Danh Sách Từ Vựng</label>
                <table class="table table-bordered table-input submit-table">
                    <thead>
                        <tr>
                            <th width="70px">Nhập tay</th>
                            <th width="50px"><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
                            <th width="70px"></th>
                            <th>Loại Từ</th>
                            <th width="200px">Tên</th>
                            <th width="200px">Phiên Âm</th>
                            <th>Nghĩa</th>
                            <th>Giải Thích (Tiếng Anh)</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hidden">
                            <td><input type="checkbox" class="edit-confirm" name=""></td>
                            <td></td>
                            <td><a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary full-width btn-popup">Tìm kiếm</a></td>
                            <td class="hidden"><input type="text" name="" refer-id="vocabulary_id" class="vocabulary_id" value=""></td>
                            <td class="hidden"><input type="text" name="" refer-id="vocabulary_dtl_id" class="vocabulary_dtl_id" value=""></td>
                            <td>
                                <select class="form-control input-sm vocabulary_div" disabled="">
                                    <option value="0"></option>
                                    <option value="1">Danh từ</option>
                                    <option value="2">Động từ</option>
                                    <option value="3">Tính từ</option>
                                    <option value="4">Trạng từ</option>
                                </select>
                            </td>
                            <td><input type="text" refer-id="vocabulary_nm" name="" class="form-control input-sm vocabulary_nm" value="" disabled=""></td>
                            <td><input type="text" refer-id="spelling" name="" class="form-control input-sm spelling" value="" disabled=""></td>
                            <td><input type="text" refer-id="mean" name="" class="form-control input-sm mean" value="" disabled=""></td>
                            <td><input type="text" refer-id="explain" name="" class="form-control input-sm explain" value="" disabled=""></td>
                            <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" class="edit-confirm" name=""></td>
                            <td>1</td>
                            <td><a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary full-width btn-popup">Tìm kiếm</a></td>
                            <td class="hidden"><input type="text" name="" refer-id="vocabulary_id" class="vocabulary_id" value=""></td>
                            <td class="hidden"><input type="text" name="" refer-id="vocabulary_dtl_id" class="vocabulary_dtl_id" value=""></td>
                            <td>
                                <select class="form-control input-sm vocabulary_div" disabled="">
                                    <option value="0"></option>
                                    <option value="1">Danh từ</option>
                                    <option value="2">Động từ</option>
                                    <option value="3">Tính từ</option>
                                    <option value="4">Trạng từ</option>
                                </select>
                            </td>
                            <td><input type="text" refer-id="vocabulary_nm" name="" class="form-control input-sm vocabulary_nm" value="" disabled=""></td>
                            <td><input type="text" refer-id="spelling" name="" class="form-control input-sm spelling" value="" disabled=""></td>
                            <td><input type="text" refer-id="mean" name="" class="form-control input-sm mean" value="" disabled=""></td>
                            <td><input type="text" refer-id="explain" name="" class="form-control input-sm explain" value="" disabled=""></td>
                            <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                        </tr>
                    </tbody>
                </table>
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