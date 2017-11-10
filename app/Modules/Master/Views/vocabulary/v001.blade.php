@extends('layout_master')
@section('title','Danh Sách Từ Vựng')
@section('button')
{{Button::menu_button(array('btn-list','btn-add','btn-update-dis','btn-delete-dis','btn-save-dis','btn-cancel-dis','btn-print-dis'))}}
@endsection
@section('content')
<div class="panel main-panel col-xs-12">
	<div class="panel-header">
		<h5 class="panel-title">Điều Kiện Lọc Danh Sách</h5>
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
	<div class="panel-header padding-10-l">
		<h5 class="panel-title">Danh Sách Từ Vựng</h5>
	</div>
	<div class="panel-content padding-10-l show-on-click" click-btn='btn-list'>
		<div class="table-fixed-width no-padding-left" min-width='1160px'>
            <table class="table table-hover table-bordered table-checkbox">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" class="super-checkbox"></th>
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
                	@for($i=1;$i<=20;$i++)
                    <tr>
                        <td><input type="checkbox" name="" class="sub-checkbox"></td>
                        <td>{{$i}}</td>
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
        <ul class="pager">
            <li><a href="#">Previous</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">Next</a></li>
        </ul>
	</div>
	<div class="panel-bottom">
		<i class="fa fa-spinner fa-spin" style="font-size:24px;text-align: center;width: 100%;display: none;"></i>
	</div>
</div>
<div class="panel main-panel col-xs-12 show-on-click" click-btn='btn-update'>
    <div class="panel-header padding-10-l">
        <h5 class="panel-title">Cập Nhật Từ Vựng</h5>
    </div>
    <div class="panel-content no-padding-left update-content">
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>ID</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="ID của từ vựng" readonly="">
                </div>
            </div>
        </div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Tên từ vựng</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm" placeholder="Tên từ vựng">
                </div>
            </div>
        </div>
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
        <div class="col-xs-12"></div>
        <div class="col-sm-3 no-padding-right">
            <div class="form-group">
                <label>Phiên âm</label>
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
            <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Giải thích</label>
                <div class="input-group">
                    <textarea class="form-control input-sm" placeholder="Giải thích về từ vựng" rows="5"></textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Hình ảnh</label>
                <div class="input-group">
                    <input type="file" name="" class="" size="5" value="">
                </div>
            </div>
        </div>
        <div class="col-sm-6 no-padding-right">
            <div class="form-group">
                <label>Âm thanh</label>
                <div class="input-group">
                    <input type="file" name="" class="" placeholder="ID của từ vựng">
                </div>
            </div>
        </div>
    </div>
    <div class="panel-bottom">
        <i class="fa fa-spinner fa-spin" style="font-size:24px;text-align: center;width: 100%;display: none;"></i>
    </div>
</div>
@stop