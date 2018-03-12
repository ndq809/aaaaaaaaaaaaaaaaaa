@extends('layout')
@section('title','E+ Học Từ Vựng')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.cssslider.js')!!}
    {!!WebFunctions::public_url('web-content/js/screen/vocabulary.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/animated-slider.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/vocabulary.css')!!}
@stop

@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> HỌC TỪ VỰNG TIẾNG ANH</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Danh mục từ vựng</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm từ vựng</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group">
                <label>Từ Khóa</label>
                <div class="input-group">
                    <input type="text" name="" class="form-control input-sm">
                </div>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top">Tìm kiếm bài học</button>
	 	</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Từ Vựng Chưa Thuộc</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Từ Vựng Đã Thuộc</a></li>
        </ul>
        <div class="tab-content focusable">
            <div id="tab1" class="tab-pane fade active in">
                <div class="">
                    <table class="table table-striped table-hover table-right">
                        <tbody>
                            @for($i=1;$i<=20;$i++)
                            @if($i==1)
                            <tr id="{{$i}}" class="activeItem">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-remember">Đã thuộc</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$i}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-remember">Đã thuộc</button>
                                </td>
                            </tr>
                            @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
                <div class="">
                    <table class="table table-striped table-hover table-right">
                        <tbody>
                             @for($i=6;$i<=10;$i++)
                            @if($i==6)
                            <tr id="{{$i}}" class="activeItem">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Đã quên</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$i}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Đã quên</button>
                                </td>
                            </tr>
                            @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main">
		<div class="col-xs-12 no-padding">
			<div class="col-lg-12 title-bar">
                <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-image">Hình ảnh</label>
                <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-audio">Âm thanh</label>
                <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-mean">Nghĩa</label>
                <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-spell">Phiên âm</label>
                <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-engword">Từ tiếng anh</label>
                <label class="checkbox-inline"><input type="checkbox" value="" checked="" id="vocal-explain">Giải thích</label>
            </div>
		</div>
		<div class="col-xs-12 no-padding">
			<div class="choose_slider vocal-image">
				<div class="choose_slider_items">
					<ul id="mySlider1">
						<li class="current_item active"><a> <img
								src="web-content/images/vocabulary/abide_by.jpg" />
						</a></li>
						@for($i=0;$i<4;$i++)
						<li class="current_item"><a> <img
								src="web-content/images/vocabulary/agreement.jpg" />
						</a></li>
						@endfor
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xs-12 no-padding hint-text">
			<h6>Bạn có thể click vào hình ảnh để nghe đọc lại từ vựng</h6>
		</div>
		<div class="col-xs-12 no-padding">
			<button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
			<button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
		</div>
		<div class="col-xs-12 no-padding vocabulary-box">
			<input type="text" name="" class="form-control input-sm vocal-engword" value="abide by" readonly="readonly">
			<input type="text" name="" class="form-control input-sm vocal-spell" value="/ə'baid/" readonly="readonly">
			<textarea class="form-control input-sm vocal-mean" readonly="readonly">tôn trọng, tuân theo, giữ (lời)</textarea>
			<textarea class="form-control input-sm vocal-explain" readonly="readonly">to accept and act according to a law, an agreement</textarea>
		</div>
	</div>
</div>

@stop

