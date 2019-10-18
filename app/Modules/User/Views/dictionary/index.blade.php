@extends('layout')
@section('title','Từ Điển E+')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/common/library/croppic.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/croppic.css')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.cssslider.js')!!}
    {!!WebFunctions::public_url('web-content/js/screen/dictionary.js')!!}
    {!!WebFunctions::public_url('web-content/css/common/library/animated-slider.css')!!}
    {!!WebFunctions::public_url('web-content/css/screen/dictionary.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content no-fixed">
	<div class="col-xs-12 no-padding">
		<div class="col-xs-12 no-padding right-header no-fixed" data-target="#menu-body" data-toggle="collapse">
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td width="95%">
                             <h5>KHUNG TÌM KIẾM</h5>
                        </td>
                        <td class="collapse-icon" width="5%"></td>
                    </tr>
                </tbody>
            </table>
        </div>
         <div class=" col-xs-12 no-padding right-content">
            <div class="col-md-12 collapse in no-padding open-when-small" id="menu-body">
               <div class="col-md-12 no-padding select-group">
                    <div class="form-group no-margin-bt has-feedback">
                        <div class="input-group">
                          <input type="text" class="form-control input-sm" id="key-word" placeholder="Nhập từ vựng cần tìm" maxlength="100" value="{{isset($data_default[0]['vocabulary_nm'])?$data_default[0]['vocabulary_nm']:''}}">
                          <span class="form-control-feedback"><img width="60px" height="40px" src="/web-content/images/plugin-icon/open-book.png"></span>
                          <input type="hidden" name="" id="key-id" value="{{isset($data_default[0]['id'])?$data_default[0]['id']:''}}">
                        </div><!-- /input-group -->
                    </div>
                </div>
                <div class="col-xs-12 bookmark">
                    @include('User::dictionary.search_history')
                </div>
            </div>
        </div>
	</div>
    <div class="col-xs-12 no-padding result-box change-content {{isset($data)&&$data[0]['id'] != ''?'':'hidden'}}">
        <div class="temp hidden" style="height:27px"></div>
        <div class="right-header col-md-12 no-padding">
            <div class="col-md-8 no-padding">
                <table class="full-width">
                    <tbody>
                        <tr>
                            <td class="text-left"><h5 class="noselect" id="btn_prev"><i class="glyphicon glyphicon-fast-backward"></i> TRƯỚC</h5></td>
                            <td class="text-center"><h5><i class="glyphicon glyphicon-education"></i> KẾT QUẢ TÌM KIẾM</h5></td>
                            <td class="text-right"><h5 class="margin-right float-right noselect" id="btn_next">TIẾP <i class="glyphicon glyphicon-fast-forward"></i></h5></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12 no-padding">
        	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Danh sách nghĩa tìm được</a></li>
                    <li class=""><a class="{{$raw_data[0][0]['btn-add-voc']==1?'':'btn-disabled'}}" data-toggle="tab" {{$raw_data[0][0]['btn-forget']==1?'href=#tab2':'btn-disabled'}} aria-expanded="false" >Đóng góp từ vựng</a></li>
                </ul>
                <div class="tab-content focusable" id="result1">
                    @include('User::dictionary.right_tab')
                </div>
            </div>
        	<div class="col-md-8 col-md-pull-4 web-main" id="result2">
                <div class="post-not-found col-xs-12 hidden">
                    <div class="image-nf">
                        <img src="/web-content/images/icon/no-result.png" width="400px">
                    </div>
                    <div class="content">
                        <h5 class="text-center" style="font-size: 20px;">TỪ BẠN VỪA TÌM KHÔNG ĐƯỢC TÌM THẤY TRONG HỆ THỐNG !!!</h5>
                    </div>
                </div>
        		@include('User::dictionary.main_content')
        	</div>
        </div>
    </div>
</div>

@stop

