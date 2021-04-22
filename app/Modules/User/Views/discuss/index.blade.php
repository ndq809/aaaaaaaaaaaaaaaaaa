@extends('layout')
@section('title','Hỏi Đáp Thảo Luận E+')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/discuss.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/discuss.css')!!}
@stop
@section('left-tab')
    @include('User::discuss.left_tab')
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
                        <td class="text-center"><h5><i class="fa fa-comments"></i> HỎI VÀ ĐÁP</h5></td>
                        <td class="text-right"><h5 class="margin-right float-right noselect" id="btn_next">TIẾP <i class="glyphicon glyphicon-fast-forward"></i></h5></td>
                    </tr>
                </tbody>
            </table>
		</div>
    </div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
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
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Bài Bạn Chưa Xem</a></li>
            <li class=""><a class="{{$raw_data[0][0]['btn-forget']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab2':'btn-disabled rank='.$raw_data[0][0]['btn-forget']}} aria-expanded="false" >Bài Bạn Theo Dõi</a></li>
        </ul>
        <div class="tab-content focusable" id="result1">
            @include('User::discuss.right_tab')
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main" id="result2">
        <div class="col-xs-12 no-padding">
            <ul class="nav nav-tabs nav-justified discuss-tab">
                <li class="active"><a data-toggle="tab" href="#tab-custom1">Câu hỏi / Thảo luận</a></li>
                <li class=""><a class="{{$raw_data[0][0]['btn-forget']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab-custom2':'btn-disabled rank='.$raw_data[0][0]['btn-forget']}} aria-expanded="false" > Đặt Câu hỏi / Chủ đề</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-custom1" class="tab-pane fade in active">
                    @if(!isset($blank))
                        @include('User::discuss.tab_custom1')
                    @else
                        @include('not_found')
                    @endif
                </div>
                <div id="tab-custom2" class="tab-pane fade input-tab">
                    @include('User::discuss.tab_custom2')
                </div>
            </div>
        </div>
        <div class="example-content">
            @if(!isset($blank))
                @include('User::discuss.main_content')
            @endif
        </div>
    </div>
</div>

@stop

