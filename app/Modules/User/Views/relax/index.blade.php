@extends('layout')
@section('title','E+ Giải Trí')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.ratemate.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/raphael-min.js')!!}
    {!!WebFunctions::public_url('web-content/player/build/mediaelement-and-player.js')!!}
    {!!WebFunctions::public_url('web-content/player/build/renderers/facebook.js')!!}
    {!!WebFunctions::public_url('web-content/player/build/mediaelementplayer.css')!!}
    {!!WebFunctions::public_url('web-content/player-plugin/dist/playlist/playlist.js')!!}
    {!!WebFunctions::public_url('web-content/player-plugin/dist/playlist/playlist.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/relax.css')!!}
    {!!WebFunctions::public_url('web-content/js/screen/relax.js')!!}
@stop
@section('left-tab')
    @include('User::relax.left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="temp hidden" style="height:27px"></div>
    <div class="right-header col-md-12 no-padding">
        <div class="col-md-8 no-padding">
            <table class="full-width">
                <tbody>
                    <tr>
                        <td class="text-left"><h5 class="noselect" id="btn_prev"><i class="glyphicon glyphicon-fast-backward"></i> TRƯỚC</h5></td>
                        <td class="text-center"><h5><i class="fa fa-rocket"></i> GIẢI TRÍ CÙNG E+</h5></td>
                        <td class="text-right"><h5 class="margin-right float-right noselect" id="btn_next">TIẾP <i class="glyphicon glyphicon-fast-forward"></i></h5></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding">
	 	<div class="col-md-12 no-padding select-group">
            <div class="form-group">
                <label>Tag Bài Viết</label>
                <div class="input-group">
                    <select class="margin-bottom tag-custom submit-item" id="post_tag" multiple="multiple">
                        @if(isset($data_default)&&$data_default[4][0]['tag_id'] != '')
                            @foreach($data_default[4] as $index => $row)
                            <option value="{{$row['tag_id']}}">{{$row['tag_nm']}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top" id="find-by-tag">Tìm kiếm theo tag</button>
        </div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Hình Ảnh</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Video</a></li>
            <li class=""><a data-toggle="tab" href="#tab3" aria-expanded="false">Truyện</a></li>
        </ul>
        <div class="tab-content focusable" id="result1">
            @include('User::relax.right_tab')
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main">
		<div class="col-xs-12 no-padding">
			<ul class="nav nav-tabs nav-justified relax-tab">
                <li class="active"><a data-toggle="tab" href="#tab-custom1">Giải trí với tiếng anh</a></li>
                <li class=""><a class="{{$raw_data[0][0]['btn-forget']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab-custom2':'btn-disabled'}} aria-expanded="false" >Đóng góp cho E+</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-custom1" class="tab-pane fade in active">
                    @include('User::relax.tab_custom1')
                </div>
                <div id="tab-custom2" class="tab-pane fade input-tab">
                    @include('User::relax.tab_custom2')
                </div>
            </div>
		</div>
        <div class="example-content">
            @include('User::relax.main_content')
        </div>
	</div>
</div>

@stop

