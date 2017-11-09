@extends('layout_master')
@section('title','Danh Sách Từ Vựng')
@section('button')
{{Button::menu_button(array('btn-list','btn-add','btn-update-dis','btn-delete-dis','btn-save-dis','btn-print-dis'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Điều Kiện Lọc Danh Sách</h5>
	</div>
	<div class="col-sm-4 no-padding-right">
	    <div class="form-group">
	        <label>Danh mục từ vựng</label>
	        <div class="input-group">
	            <select class="form-control input-sm">
	                <option>this is select box</option>
	            </select>
	        </div>
	    </div>
	</div>
	<div class="col-sm-4 no-padding-right">
	    <div class="form-group">
	        <label>Nhóm từ vựng</label>
	        <div class="input-group">
	            <select class="form-control input-sm">
	                <option>this is select box</option>
	            </select>
	        </div>
	    </div>
	</div>
	<div class="col-sm-4 no-padding-right">
        <div class="form-group">
            <label>Từ khóa</label>
            <div class="input-group">
                <input type="text" name="" class="form-control input-sm" placeholder="Từ khóa của từ vựng">
            </div>
        </div>
    </div>
	<div class="panel-bottom"></div>
</div>
<div class="panel main-panel col-xs-12">
	<div class="panel-header padding-10-l">
		<h5 class="panel-title">Danh Sách Từ Vựng</h5>
	</div>
	<div class="panel-content padding-10-l">
		<div class="table-fixed-width hidden" min-width='1160px'>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" class="super-checkbox"></th>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Danh Mục</th>
                        <th>Nhóm</th>
                        <th>Nghĩa</th>
                        <th>Phiên Âm</th>
                        <th>Giải Thích</th>
                        <th>Hình Ảnh</th>
                        <th>Âm Thanh</th>
                    </tr>
                </thead>
                <tbody>
                	@for($i=1;$i<=10;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
                        <td>Abide by</td>
                        <td>600 từ vựng toleic</td>
                        <td>business</td>
                        <td>tôn trọng, tuân theo, giữ (lời)</td>
                        <td>/ə'baid/</td>
                        <td class="td-1-line">to accept and act according to a law, an agreement</td>
                        <td>Abide_by.jpg</td>
                        <td>Abide_by.mp3</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
	</div>
	<div class="panel-bottom">
		<i class="fa fa-spinner fa-spin" style="font-size:24px;text-align: center;width: 100%;display: none;"></i>
	</div>
</div>
@stop