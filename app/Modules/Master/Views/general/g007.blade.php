@extends('layout_master')
@section('title','Lịch Sử Thao Tác')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/general/g007.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/general/g007.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-search','btn-print'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Điều Kiện Tra Cứu</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Người Thực Hiện</label>
                <select>
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Thao Tác</label>
                <select>
                    <option>Tất cả</option>
                    <option>Cập nhật</option>
                    <option>Thêm mới</option>
                    <option>Xóa</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Thời Gian</label>
                <div class="input-group picker">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" value="this is Datepicker" readonly="">
                    <span class="input-group-text">~</span>
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input type="text" name="" class="form-control input-sm" data-field="date" data-format="MM/yyyy" value="this is Datepicker" readonly="">
                </div>
            </div>
        </div>
        <div class="col-xs-12"></div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Đối Tượng Thao Tác</label>
                <select>
                    <option>Tất cả</option>
                    <option>Từ vựng</option>
                    <option>Ngữ pháp</option>
                    <option>Thành Viên</option>
                </select>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Sắp Xếp Theo</label>
                <select>
                    <option>Tất cả</option>
                </select>
            </div>
        </div>
        </div>
    <div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Lịch Sử Thao Tác</h5>
    </div>
    <div class="panel-content no-padding-left show-on-click" click-btn='btn-search'>
        <div class="col-xs-12 no-padding-right">
            <div class="table-fixed-width no-padding-left" min-width='1160px'>
                <table class="table table-hover table-bordered table-checkbox">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="" class="super-checkbox"></th>
                            <th>ID</th>
                            <th>Loại Thao Tác</th>
                            <th>Ngày Thao Tác</th>
                            <th>Giờ Thao Tác</th>
                            <th>Người Thao Tác</th>
                            <th>Nội Dung Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=1;$i<=5;$i++)
                        <tr>
                            <td><input type="checkbox" name="" class="sub-checkbox"></td>
                            <td>00{{$i}}</td>
                            <td>Cập Nhật</td>
                            <td>22/12/2017</td>
                            <td>19:17:22</td>
                            <td>Quy Nguyen</td>
                            <td class="text-left">Cập nhật danh mục từ vựng</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            @if(!isset($paging))
            @php
                $paging=array('page' => 6,'pagesize' => 15,'totalRecord' => 100,'pageMax'=>10 )
            @endphp
            @endif
            @if($paging['totalRecord'] != 0)
                <div class=" text-center no-padding-left">
                    {!!Paging::show($paging,0)!!}
                </div>
            @endif
        </div>
    </div>
    <div class="panel-bottom">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
</div>
@stop