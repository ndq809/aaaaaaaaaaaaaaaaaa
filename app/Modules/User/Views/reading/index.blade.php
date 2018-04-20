@extends('layout')
@section('title','E+ Đọc Hiểu')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/reading.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/reading.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> ĐỌC HIỂU TIẾNG ANH</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Danh mục Bài Đọc</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm Bài Đọc</label>
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
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Bài Đọc Chưa Học</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Bài Đọc Đã Học</a></li>
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
                                    <button class="btn btn-sm btn-default" type-btn="btn-remember">Đã hiểu</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$i}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-remember">Đã hiểu</button>
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
			<div class="example-header title-header">
                <span>Chủ Ngữ !</span>
            </div>
		</div>
		<div class="col-xs-12 no-padding">
			<div class="main-content " id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;">
                <p>Chủ ngữ là chủ thể của hành động trong câu, thường đứng trước động từ (verb). Chủ ngữ thường là một danh từ (noun) hoặc một ngữ danh từ (noun phrase - một nhóm từ kết thúc bằng một danh từ, trong trường hợp này ngữ danh từ không được bắt đầu bằng một giới từ). Chủ ngữ thường đứng ở đầu câu và quyết định việc chia động từ.&nbsp;&nbsp;<br>
                Chú ý rằng mọi câu trong tiếng Anh đều có chủ ngữ (Trong câu mệnh lệnh, chủ ngữ được ngầm hiểu là người nghe. Ví dụ: “Don't move!” = Đứng im!).&nbsp;<br>
                &nbsp;Milk is delicious. (một danh từ)&nbsp;&nbsp;&nbsp;&nbsp;</p>

                <p>That new, red car is mine. (một ngữ danh từ)&nbsp;&nbsp;<br>
                Đôi khi câu không có chủ ngữ thật sự, trong trường hợp đó, It hoặc There đóng vai trò chủ ngữ giả.&nbsp;<br>
                It is a nice day today.&nbsp;&nbsp;&nbsp;&nbsp;</p>

                <p>There is a fire in that building.&nbsp;&nbsp;&nbsp;</p>

                <p>There were many students in the room.&nbsp;</p>

                <p>It is the fact that the earth goes around the sun.</p>
            </div>
		</div>
		<div class="col-xs-12 no-padding margin-top">
			<button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
			<button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
		</div>
        <div class="col-xs-12 no-padding margin-top">
            <div class="right-header">
                <h5><i class="glyphicon glyphicon-star-empty"></i> Từ Mới , Bài Tập</h5>
            </div>
            <div class="panel-group" id="example-list">
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse1">
                    <h5 class="panel-title">
                      <span>Danh Sách Từ Mới Của Bài Viết</span>
                    </h5>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse in">
                    <div class="">
                        <table class="table vocabulary-table table-hover">
                            <tbody>
                                <tr>
                                    <td width="33%">Hello</td>
                                    <td width="33%">hə'lou</td>
                                    <td>Xin Chào</td>
                                </tr>
                                <tr>
                                    <td width="33%">Hello</td>
                                    <td width="33%">hə'lou</td>
                                    <td>Xin Chào</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default panel-contribute">
                 <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse6">
                    <h5 class="panel-title">
                      <span>Bài Tập Tự Luyện</span>
                    </h5>
                  </div>
                  <div id="collapse6" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="col-xs-12 no-padding practice-qs">
                            <label>1.It is the fact that the earth goes around the sun ?</label>
                            <div class="form-group">
                                <label class="radio-inline"><input type="radio" name="optradio">There is a fire in that building.   </label>
                                <label class="radio-inline"><input type="radio" name="optradio">It is a nice day today. </label>
                                <label class="radio-inline"><input type="radio" name="optradio">It is the fact that the earth goes around the sun.It is the fact that the earth goes around the sun.It is the fact that the earth goes around the sun.It is the fact that the earth goes around the sun.</label>
                                <label class="radio-inline"><input type="radio" name="optradio">There were many students in the room. </label>
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding practice-qs">
                            <label>2.It is the fact that the earth goes around the sun ?</label>
                            <div class="form-group">
                                <label class="checkbox-inline"><input type="checkbox" name="optradio1">There is a fire in that building.   </label>
                                <label class="checkbox-inline"><input type="checkbox" name="optradio2">It is a nice day today. </label>
                                <label class="checkbox-inline"><input type="checkbox" name="optradio3">It is the fact that the earth goes around the sun.</label>
                                <label class="checkbox-inline"><input type="checkbox" name="optradio4">There were many students in the room. </label>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-danger">Trả Lời</button>
                    </div>
                  </div>
                </div>
            </div> 
        </div>
		<div class="col-xs-12 no-padding">
			<div class="commentbox">
                <div class="titleBox">
                    <label>Bình luận</label>
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                </div>
                <div class="actionBox" style="padding: 0px;">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm"
                            placeholder="Bình luận của bạn" />
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-sm btn-comment" id="btBinhLuan">Bình Luận </button>
                        </div>
                    </div>
                    <a href="" class="hidden see-back">Xem bình luận trước đó</a>
                    <ul class="commentList">
                    </ul>
                    <button class="btn btn-default btn-sm full-width margin-top btn-more-cmt">Hiện thêm bình luận</button>
                </div>
            </div>
		</div>
	</div>
</div>

@stop

