@extends('layout_master')
@section('title','Quản Lý Phân Quyền')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen_master/system/s001.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen_master/system/s001.css')!!}
@stop
@section('button')
{{Button::menu_button(array('btn-save','btn-print'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Đối Tượng Phân Quyền</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Loại Người Dùng</label>
                <select>
                    <option>Tất cả</option>
                    <option>DC</option>
                    <option>UC</option>
                    <option>MC</option>
                </select>
            </div>
        </div>
        <div class="panel-bottom"></div>
    </div>
</div>
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Chi Tiết Phân Quyền</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-xs-12 no-padding-right">
            <div class="table-fixed-width no-padding-left" min-width='1160px'>
                <table class="table table-hover table-bordered table-multicheckbox">
                    <thead>
                        <tr>
                            <th rowspan="2">Mã Màn Hình</th>
                            <th rowspan="2">Tên Màn Hình</th>
                            <th colspan="6">Quyền Hạn</th>
                            <th rowspan="2">Ghi Chú</th>
                        </tr>
                        <tr>
                            <th><label class="checkbox-inline"><input type="checkbox" class="super-checkbox" group="1">Truy Cập</label></th>
                            <th><label class="checkbox-inline"><input type="checkbox" class="super-checkbox" group="2">Hiển Thị Menu</label></th>
                            <th><label class="checkbox-inline"><input type="checkbox" class="super-checkbox" group="3">Thêm Dữ Liệu</label></th>
                            <th><label class="checkbox-inline"><input type="checkbox" class="super-checkbox" group="4">Sửa Dữ Liệu</label></th>
                            <th><label class="checkbox-inline"><input type="checkbox" class="super-checkbox" group="5">Xóa Dữ Liệu</label></th>
                            <th><label class="checkbox-inline"><input type="checkbox" class="super-checkbox" group="6">Xuất Dữ Liệu</label></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=1;$i<=5;$i++)
                        <tr style="background: #ebeae1">
                            <td colspan="2" >QUẢN LÝ DỮ LIỆU</td>
                            <td><input type="checkbox" name="" class="sub-checkbox super-checkbox" group="1{{$i}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox super-checkbox" group="2{{$i}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox super-checkbox" group="3{{$i}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox super-checkbox" group="4{{$i}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox super-checkbox" group="5{{$i}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox super-checkbox" group="6{{$i}}"></td>
                            <td></td>
                        </tr>
                        @for($j=1;$j<=5;$j++)
                        <tr>
                            <td>m003</td>
                            <td>Quản Lý Nhân Viên</td>
                            <td><input type="checkbox" name="" class="sub-checkbox" group="1{{$i.$j}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox" group="2{{$i.$j}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox" group="3{{$i.$j}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox" group="4{{$i.$j}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox" group="5{{$i.$j}}"></td>
                            <td><input type="checkbox" name="" class="sub-checkbox" group="6{{$i.$j}}"></td>
                            <td><input type="text" name="" class="form-control input-sm"></td>
                        </tr>
                        @endfor
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="panel-bottom">
        <i class="fa fa-spinner fa-spin"></i>
    </div>
</div>
@stop