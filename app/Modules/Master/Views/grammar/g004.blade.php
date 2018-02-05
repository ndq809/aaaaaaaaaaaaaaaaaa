@extends('layout_master')
@section('title','Thêm Mới Ngữ Pháp')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/grammar/g004.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/grammar/g004.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-add','btn-delete','btn-print','btn-manager-page'))}}
@endsection
@section('content')
<div class="link-div" btn-manager-page-link='/master/v001'></div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Mới Từ Vựng</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên Từ Vựng</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên từ vựng">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Danh Mục Của Từ Vựng</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Nhóm Của Từ Vựng</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Phiên Âm</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Phiên âm từ vựng">
                </div>
            </div>
        </div>
        <div class="col-sm-9 no-padding-right">
            <div class="form-group">
                <label>Nghĩa</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Nghĩa của từ vựng">
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-xs-12"></div>
            <div class="col-sm-12 no-padding-right">
            <div class="form-group">
                <label>Giải Thích</label>
                <div class="input-group">
                    <textarea class="form-control input-sm" placeholder="Giải thích về từ vựng" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Hình Ảnh</label>
                <div class="input-group">
                    <input type="file" class="input-image" name=""  value="">
                </div>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Âm Thanh</label>
                <div class="input-group">
                    <input type="file" name="" class="input-audio" placeholder="ID của từ vựng">
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
        <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-checkbox table-new-row">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Danh Mục</th>
                        <th>Nhóm</th>
                        <th>Phiên Âm</th>
                        <th>Nghĩa</th>
                        <th>Giải Thích</th>
                        <th>Hình Ảnh</th>
                        <th>Âm Thanh</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td>Abide by</td>
                        <td>600 từ vựng toleic</td>
                        <td>business</td>
                        <td>/ə'baid/</td>
                        <td>tôn trọng, tuân theo, giữ (lời)</td>
                        <td class="td-1-line">to accept and act according to a law, an agreement</td>
                        <td>Abide_by.jpg</td>
                        <td>Abide_by.mp3</td>
                    </tr>
                    @for($i=1;$i<=5;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>00{{$i}}</td>
                        <td>Abide by</td>
                        <td>600 từ vựng toleic</td>
                        <td>business</td>
                        <td>/ə'baid/</td>
                        <td>tôn trọng, tuân theo, giữ (lời)</td>
                        <td class="td-1-line">to accept and act according to a law, an agreement</td>
                        <td>Abide_by.jpg</td>
                        <td>Abide_by.mp3</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
@stop