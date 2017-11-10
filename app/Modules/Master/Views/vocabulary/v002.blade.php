@extends('layout_master')
@section('title','Quản lý danh mục')
@section('button')
{{Button::menu_button(array('btn-new-row','btn-delete','btn-save','btn-cancel','btn-print'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
    <div class="panel-header">
        <h5 class="panel-title">Thêm Mới Danh Mục</h5>
    </div>
    <div class="panel-content no-padding-left">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Danh mục từ vựng</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Nhóm từ vựng</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Từ khóa</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Từ khóa của từ vựng">
                </div>
            </div>
        </div>
    </div>
    <div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Quản Lý Danh Mục</h5>
	</div>
    <div class="panel-content padding-10-l">
	   <div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered new-row-table">
                <thead>
                    <tr>
                        <th width="50px"><input type="checkbox" name="" class="super-checkbox"></th>
                        <th width="50px">ID</th>
                        <th width="100px">Mã Danh Mục</th>
                        <th>Tên Danh Mục</th>
                        <th width="100px">Số Nhóm</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hidden">
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td></td>
                        <td class="text-left"></td>
                        <td class="text-left"><input type="text" name="" class="form-control input-sm" value=""></td>
                        <td>0</td>
                    </tr>
                    @for($i=1;$i<=20;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td class="text-left">DM00{{$i}}</td>
                        <td class="text-left"><input type="text" name="" class="form-control input-sm" value="600 từ vựng toleic"></td>
                        <td>23</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
@stop