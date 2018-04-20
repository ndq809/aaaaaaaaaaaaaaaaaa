@extends('layout')
@section('title','E+ Học Ngữ Pháp')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/grammar.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/grammar.css')!!}
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> HỌC NGỮ PHÁP TIẾNG ANH</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding" >
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Danh mục Ngữ Pháp</label>
                <select>
                    <option>this is select box</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nhóm Ngữ Pháp</label>
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
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Ngữ Pháp Chưa Học</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Ngữ Pháp Đã Học</a></li>
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
                <h5><i class="glyphicon glyphicon-star-empty"></i> Ví Dụ Thực Tế</h5>
            </div>
            <div class="panel-group" id="example-list">
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse1">
                    <h5 class="panel-title">
                      <span>There were many students in the room. There were many students in the room. </span>
                    </h5>
                    <span class="number-clap">1,5k</span>
                    <a href="" class="fa fa-signing claped" title="Hay quá ! Vỗ tay!!!"></a>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">Đã có nhiều học sinh ở trong phòng</div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse2">
                    <h5 class="panel-title">
                      <span>There is a fire in that building.</span>
                    </h5>
                    <span class="number-clap">800</span>
                    <a href="" class="fa fa-signing"></a>
                  </div>
                  <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">Lửa cháy ở trong tòa nhà đó</div>
                  </div>
                </div>
                <div class="panel panel-default">
                 <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse3">
                    <h5 class="panel-title">
                      <span>It is the fact that the earth goes around the sun.</span>
                    </h5>
                    <span class="number-clap">12</span>
                    <a href="" class="fa fa-signing"></a>
                  </div>
                  <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">Trái đất quay quanh mặt trời là sự thật</div>
                  </div>
                </div>
                <div class="panel panel-default">
                 <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse4">
                    <h5 class="panel-title">
                      <span>It is the fact that the earth goes around the sun.</span>
                    </h5>
                    <span class="number-clap">12</span>
                    <a href="" class="fa fa-signing"></a>
                  </div>
                  <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body">Trái đất quay quanh mặt trời là sự thật</div>
                  </div>
                </div>
                <div class="panel panel-default">
                 <div class="panel-heading" data-toggle="collapse" data-parent="#example-list" href="#collapse5">
                    <h5 class="panel-title">
                      <span>It is the fact that the earth goes around the sun.</span>
                    </h5>
                    <span class="number-clap">12</span>
                    <a href="" class="fa fa-signing"></a>
                  </div>
                  <div id="collapse5" class="panel-collapse collapse">
                    <div class="panel-body">Trái đất quay quanh mặt trời là sự thật</div>
                  </div>
                </div>
                <div class="panel panel-default panel-contribute">
                 <div class="panel-heading " data-toggle="collapse" data-parent="#example-list" href="#collapse6">
                    <h5 class="panel-title">
                      <span>Đóng góp ví dụ cho ngữ pháp này</span>
                    </h5>
                  </div>
                  <div id="collapse6" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="col-xs-12 no-padding">
                            <div class="form-group">
                                <label>Câu Tiếng Anh</label>
                                 <div class="input-group">
                                    <input type="text" name="" class="form-control input-sm" placeholder="Nội dung câu tiếng anh">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 no-padding">
                            <div class="form-group">
                                <label>Dịch Nghĩa</label>
                                 <div class="input-group">
                                    <input type="text" name="" class="form-control input-sm" placeholder="Nghĩa của câu đã nhập">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-danger">Đóng Góp</button>
                    </div>
                  </div>
                </div>
                @if(!isset($paging))
                    @php
                        $paging=array('page' => 6,'pagesize' => 15,'totalRecord' => 100,'pageMax'=>10 )
                    @endphp
                @endif
                @if($paging['totalRecord'] != 0)
                    <div class=" text-center no-padding-left margin-bottom">
                        {!!Paging::show($paging,0)!!}
                    </div>
                @endif
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

