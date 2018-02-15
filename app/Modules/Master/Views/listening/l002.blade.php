@extends('layout_master')
@section('title','Thêm Mới Bài Nghe')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/listening/l002.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/listening/l002.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-print','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/l001'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Nội Dung Thêm Mới</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Danh Mục Của Bài Nghe</label>
                <select>
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Nhóm Của Bài Nghe</label>
                <select>
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Tiêu Đề Của Bài Nghe</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên từ vựng">
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Nội Dung Bài Nghe</label>
                <div class="input-group">
                    <textarea name="gra-content" class="form-control input-sm" rows="7"></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 no-padding-right">
            <div class="form-group old-item">
                <label>Âm Thanh Mặc Định</label>
                <div class="input-group file-subitem">
                    <div class="audio-title text-center">
                        <h6>Em Gái Mưa (Cover) Anh Khang Lyric Loi bai hat _ cogmVVx0q0As.mp3</h6>
                    </div>
                    <div class="audio-source">
                        <audio controls>
                          <source src="/web-content/audio/listeningAudio/Em Gái Mưa (Cover) Anh Khang Lyric Loi bai hat _ cogmVVx0q0As.mp3" type="audio/mpeg">
                        </audio>
                    </div>
                </div>
            </div>
            <div class="form-group new-item">
                <label class="invisible">.</label>
                <div class="input-group file-subitem">
                    <input type="file" name="" class="input-audio" placeholder="ID của từ vựng">
                </div>
            </div>
        </div>
        <div class="col-sm-12 no-padding-right">
            <div class="form-group table-fixed-width" min-width='600px'>
                <label>Danh Sách Từ Vựng</label>
                <table class="table table-hover table-bordered table-input">
                    <thead>
                        <tr>
                            <th><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
                            <th>Tên</th>
                            <th>Phiên Âm</th>
                            <th>Nghĩa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hidden">
                            <td></td>
                            <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                            <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                        </tr>
                        @for($i=1;$i<=5;$i++)
                        <tr>
                            <td>{{$i}}</td>
                            <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                            <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                            <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                        </tr>
                        @endfor
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
                        <th>Số Từ Vựng</th>
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
                        <td>10</td>
                    </tr>
                    @for($i=1;$i<=5;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td>Abide by</td>
                        <td>Các thì trong tiếng anh</td>
                        <td>600 từ vựng toleic</td>
                        <td class="text-left">Người theo hương hoa mây mù giăng lối</td>
                        <td>10</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop