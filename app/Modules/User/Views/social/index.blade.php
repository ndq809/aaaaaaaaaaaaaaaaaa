@extends('layout')
@section('title','Cộng Đồng E+')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/social.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.ratemate.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/raphael-min.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/social.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> CỘNG ĐỒNG E+</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Độ Khó Bài Viết</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group">
                <label>Chủ Đề Bài Viết</label>
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
            <button class="btn btn-sm btn-primary full-width margin-top">Tìm kiếm bài đăng</button>
	 	</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Bài Bạn Chưa Xem</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Bài Bạn Theo Dõi</a></li>
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
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Theo dõi</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$i}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Theo dõi</button>
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
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Bỏ theo dõi</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$i}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Bỏ theo dõi</button>
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
            <ul class="nav nav-tabs nav-justified social-tab">
                <li class="active"><a data-toggle="tab" href="#example">Bài viết của Epluser</a></li>
                <li><a data-toggle="tab" href="#question">Góc câu hỏi / Thảo luận</a></li>
            </ul>
            <div class="tab-content">
                <div id="example" class="tab-pane fade in active">
                    <div class="example-header title-header">
                        <span>Chủ Ngữ !</span>
                    </div>
                    <div class="main-content" id="noiDungNP">
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
                <div id="question" class="tab-pane fade">
                    <div class="example-header text-header">
                        <span>Chủ ngữ là chủ thể của hành động trong câu, thường đứng trước động từ (verb). Chủ ngữ thường là một danh từ (noun) hoặc một ngữ danh từ (noun phrase - một nhóm từ kết thúc bằng một danh từ ?</span>
                    </div>
                    <div class="main-content" id="noiDungNP">
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
            </div>
		</div>
        <div class=" col-xs-12 no-padding rate-bar">
            <button class="btn btn-sm col-md-3 col-sm-3 col-xs-5"><span style="font-weight: bold;">Đánh giá</span></button>
            <div class="col-md-6 col-sm-6 col-xs-7 ratestar-bar">
                <div class="rateit" data-rateit-resetable="false" data-rateit-mode="font"  style="font-size:36px"> </div>
            </div>
            <button class="btn btn-sm col-md-3 col-sm-3 col-xs-12 btn-popup" popup-id="popup-box2"><span style="font-weight: bold;">Báo Cáo Bài Viết !</span></button>
        </div>
		<div class="col-xs-12 no-padding margin-top control-btn">
			<button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
            <button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
		</div>
        <div class="col-xs-12 no-padding margin-top margin-bottom list-panel">
            <div class="right-header">
                <h5><i class="glyphicon glyphicon-star-empty"></i> Từ Mới</h5>
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
            </div> 
        </div>
		<div class="col-xs-12 no-padding">
            <ul class="nav nav-tabs nav-justified comment-tabs">
                <li class="active"><a data-toggle="tab" href="#chemgio" aria-expanded="true">Bình Luận ,Chém Gió</a></li>
                <li class=""><a data-toggle="tab" href="#gopy" aria-expanded="false">Góp Ý Học Tập</a></li>
            </ul>
            <div class="tab-content">
                <div id="chemgio" class="tab-pane fade active in">
                    <div class="main-content commentbox">
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
                            <button class="btn btn-default btn-sm full-width margin-top btn-more-cmt">Hiện thêm bình luận<span class="load-icon"></span></button>
                        </div>
                    </div>
                </div>
                <div id="gopy" class="tab-pane fade">
                    <div class="main-content commentbox">
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
                            <button class="btn btn-default btn-sm full-width margin-top btn-more-cmt" type="button">Hiện thêm bình luận<span class="load-icon"></span></button>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>

@stop

