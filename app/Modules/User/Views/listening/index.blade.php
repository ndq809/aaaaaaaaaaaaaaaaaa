@extends('layout')
@section('title','E+ Học Nghe')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.jplayer.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jplayer.playlist.js')!!}
    {!!WebFunctions::public_url('web-content/js/screen/listening.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/jplayer.blue.monday.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/listening.css')!!}
@stop

@section('content')
<div class="col-xs-12 no-padding">
    <div id="popup-box3" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal" type="button">
                        ×
                    </button>
                    <h5 class="modal-title">
                        KẾT QUẢ BÀI NGHE
                    </h5>
                </div>
                <div class="modal-body">
                    <h5>Bạn đã nghe được <span class="listen_result"></span> của bài nghe!!!</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" data-dismiss="modal" type="button">
                        <i class="glyphicon glyphicon-thumbs-up"></i> Tiếp Tục Nghe 
                    </button>
                    <button class="btn btn-default btn-sm" data-dismiss="modal" type="button">
                        <i class="glyphicon glyphicon-thumbs-down"></i> Xem Đáp Án
                    </button>
                </div>
            </div>
        </div>
    </div>
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> HỌC NGHE TIẾNG ANH</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Độ khó bài nghe</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top">Bắt đầu học</button>
	 	</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Bài Đã Nghe</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Bài Chưa Nghe</a></li>
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
                <h5><i class="glyphicon glyphicon-flag"></i> Nghe kỹ bài nghe sau đó nghi lại những gì bạn nghe được rồi so sánh với đáp án!!!</h5>
            </div>
		</div>
		<div class="col-xs-12 no-padding margin-top">
			<div id="jquery_jplayer_2" class="jp-jplayer"></div>
                <div id="jp_container_2" class="jp-audio" role="application"
                    aria-label="media player">
                    <div class="jp-type-playlist">
                        <div class="jp-gui jp-interface">
                            <div class="jp-controls">

                                <button class="jp-play" role="button" tabindex="0">play</button>

                                <button class="jp-stop" role="button" tabindex="0">stop</button>
                            </div>
                            <div class="jp-progress">
                                <div class="jp-seek-bar">
                                    <div class="jp-play-bar"></div>
                                </div>
                            </div>
                            <div class="jp-volume-controls">
                                <button class="jp-mute" role="button" tabindex="0">mute</button>
                                <button class="jp-volume-max" role="button" tabindex="0">max
                                    volume</button>
                                <div class="jp-volume-bar">
                                    <div class="jp-volume-bar-value"></div>
                                </div>
                            </div>
                            <div class="jp-time-holder">
                                <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                            </div>
                            <div class="jp-toggles"></div>
                            <div class="jp-title">&nbsp;</div>
                        </div>

                        <div class="jp-playlist">
                            <ul>
                                <li>&nbsp;</li>
                            </ul>
                        </div>

                        <div class="jp-no-solution">
                            <span>Update Required</span> To play the media you will need to
                            either update your bcol-xs-12 no-paddingser to a recent version or update your <a
                                href="http://get.adobe.com/flashplayer/" target="_blank">Flash
                                plugin</a>.
                        </div>
                    </div>
                </div>
		</div>
		<div class="col-xs-12 no-padding">
			<h5 class="hint-text">Danh sách từ mới của bài nghe</h5>
            <div class="col-md-2 col-sm-2"></div>
            <div class="col-md-8 col-sm-8">
                <table class="table vocabulary-table">
                    <tbody>
                        <tr>
                            <td>Hello</td>
                            <td>Xin Chào</td>
                            <td>Hello</td>
                            <td>Xin Chào</td>
                        </tr>
                        <tr>
                            <td>Hello</td>
                            <td>Xin Chào</td>
                            <td>Hello</td>
                            <td>Xin Chào</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2 col-sm-2"></div>
		</div>
		<div class="col-xs-12 no-padding">
			<button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
			<button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
		</div>
		<div class="col-xs-12 no-padding listen-check-box">
			<textarea class="form-control input-sm margin-top" col-xs-12 no-paddings="3">tôn trọng, tuân theo, giữ (lời)</textarea>
            <button class="btn btn-sm btn-primary margin-top" id="check-listen-btn">Kiểm tra kết quả</button>
			<textarea class="form-control input-sm margin-top" col-xs-12 no-paddings="3" readonly=""></textarea>
		</div>
	</div>
</div>

@stop

