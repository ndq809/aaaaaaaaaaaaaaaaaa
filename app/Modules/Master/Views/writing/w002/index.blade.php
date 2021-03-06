@extends('layout_master')
@section('title','Quản Lý Bài Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/writing/w002.js')!!}
    {!!WebFunctions::public_url('web-content/compromise/builds/compromise.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/writing/w002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-save','btn-delete','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/writing/w001'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Nội Dung Quản Lý</h5>
    </div>
    <div class="panel-content no-padding-left update-block">
         <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Mã Bài Viết</label>
                <div class="input-group">
                    <input id="post_id" type="text" name="" class="form-control input-sm submit-item" placeholder="Nhập mã để chọn hoặc để trống khi thêm mới">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Danh Mục</label>
                 <select class="allow-selectize required submit-item" id="catalogue_div">
                    @foreach($data_default[0] as $item)
                        <option value="{{$item['number_id']==0?'':$item['number_id']}}">{{$item['content']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right transform-content catalogue_nm" transform-div='1,2,3,4,5,11'>
            <div class="form-group">
                <label>Tên Danh Mục</label>
                <select class="submit-item custom-selectized new-allow required" id="catalogue_nm">
                    @foreach($data_default[2] as $item)
                        <option value="{{$item['value']==0?'':$item['value']}}" data-data='{{json_encode($item)}}'>{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right transform-content group_nm" transform-div='1,2,3,4,5,11'>
            <div class="form-group">
                <label>Tên Nhóm</label>
                <select id="group_nm" class="submit-item custom-selectized new-allow required">
                    @foreach($data_default[3] as $item)
                        <option value="{{$item['value']==0?'':$item['value']}}" data-data='{{json_encode($item)}}'>{{$item['text']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-6  col-md-12 col-sm-12 no-padding-right transform-content" transform-div='2,3,4,5,6,7,8,9,10'>
            <div class="form-group">
                <label>Tiêu Đề Của Bài Viết</label>
                <div class="input-group">
                    <input type="text" id="post_title" name="" class="form-control input-sm submit-item" placeholder="Tiêu đề bài viết">
                </div>
            </div>
        </div>

        <div class="col-lg-6  col-md-12 col-sm-12 no-padding-right transform-content" transform-div='5'>
            <div class="form-group">
                <label>Tiêu Đề Của Bài Viết (Dịch)</label>
                <div class="input-group">
                    <input type="text" id="post_title_tran" name="" class="form-control input-sm submit-item" placeholder="Tiêu đề bài viết">
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 no-padding-right transform-content post_tag" transform-div='2,4,6,7,8,9,10'>
            <div class="form-group">
                <label>Tag Của Bài Viết</label>
                <div class="input-group">
                    <select class="margin-bottom custom-selectized tag-selectized submit-item" id="post_tag" multiple="multiple">
                    @foreach($data_default[4] as $item)
                        <option value="{{$item['tag_id']==0?'':$item['tag_id']}}" data-data='{{json_encode($item)}}'>{{$item['tag_nm']}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>

        <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
            <div class="col-lg-3 col-md-3 col-sm-4 no-padding-right hidden old-content" transform-div='3'>
                <div class="form-group">
                    <label>Âm thanh Cũ</label>
                    <div class="input-group audio-custom-cover">
                        <input type="file" class="old-input-audio hidden" disabled="">
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-4 no-padding-right transform-content required" transform-div='3'>
                <div class="form-group">
                    <label>Âm thanh</label>
                    <div class="input-group audio-custom-cover">
                        <input type="file" id="post_media" name="" class="input-audio" placeholder="ID của từ vựng">
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-6 col-sm-10 no-padding-right old-content hidden" transform-div='7'>
                <div class="form-group">
                    <label>Hình Ảnh Cũ</label>
                    <div class="input-group old-image">
                        <input type="file" class="old-input-image-custom hidden" value="" disabled="">
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-6 col-sm-10 no-padding-right transform-content required" transform-div='7'>
                <div class="form-group">
                    <label>Hình Ảnh</label>
                    <div class="input-group new-image">
                        <input type="file" id="post_media" class="input-image-custom" name=""  value="">
                    </div>
                </div>
            </div>

        </form>
        <div class="col-md-12 col-sm-12 no-padding-right transform-content" transform-div='8,10'>
            <div class="form-group">
                <label>Link video</label>
                <div class="input-group link-media">
                    <input type="text" id="post_media" class="input-sm form-control submit-item required" name="">
                </div>
            </div>
        </div>

        <div class="col-xs-12"></div>

        <div class="col-lg-6 col-md-12 col-sm-12 no-padding-right transform-content" transform-div='2,3,4,5,6,7,8,9,10'>
            <div class="form-group">
                <label>Nội Dung Bài Viết</label>
                <label class="btn btn-primary btn-sm float-right transform-content" transform-div='3'>Phân tách bài nghe</label>
                <div class="input-group content-box">
                    <textarea name="gra-content" id="post_content" contenteditable="true" class="form-control input-sm ckeditor submit-item" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 no-padding-right transform-content" transform-div='3' id="result3">
            @include('Master::writing.w002.refer_listen')
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 no-padding-right transform-content" transform-div='2,4,6,7,8,9,10'>
            <div class="form-group">
                <label>Preview Bài Viết</label>
                <div class="input-group preview-box">
                    <div class="col-xs-12 no-padding">
                        <div class="example-header title-header">
                            <span>Tiêu đề bài viết</span>
                        </div>
                    </div>
                    <div class="main-content" id="noiDungNP">Nội dung bài viết</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 no-padding-right transform-content" transform-div='5'>
            <div class="form-group">
                <label>Nội Dung Bài Viết (Dịch)</label>
                <div class="input-group content-box">
                    <textarea name="gra-content" id="post_content_tran" contenteditable="true" class="form-control input-sm ckeditor submit-item" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="col-sm-12 no-padding-right transform-content" transform-div='1,3,4,5'>
            <div class="form-group table-fixed-width" min-width="1024px">
                <a type="button" href="/master/popup/p003" class="btn btn-sm btn-primary btn-popup">Duyệt danh sách từ vựng</a>
                <div class="result">
                    @include('Master::writing.w002.refer_voc')
                </div>
            </div>
        </div>

        <div class="col-sm-12 no-padding-right transform-content" transform-div='2' id="result1">
            @include('Master::writing.w002.refer_exa')
        </div>

        <div class="col-sm-12 no-padding-right transform-content" transform-div='2,5,11' id="result2">
            @include('Master::writing.w002.refer_pra')
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Nguồn Bài Viết</label>
                <div class="input-group">
                    <textarea id="source" type="text" name="" rows="3" class="form-control input-sm submit-item required" placeholder="Nguồn của bài viết">{{Auth::user()->signature}}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Ghi Chú(nội dung thêm mới,thay đổi)</label>
                <div class="input-group">
                    <textarea id="notes" type="text" name="" rows="3" class="form-control input-sm submit-item required" placeholder="Ghi chú về nội dung đã thêm hoặc thay đổi dùng để thông báo cho người dùng"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@stop