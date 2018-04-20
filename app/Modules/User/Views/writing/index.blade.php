@extends('layout')
@section('title','E+ Tập Viết')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/writing.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/writing.css')!!}
    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
@stop
@section('left-tab')
    @include('left_tab')
@stop
@section('content')
<div class="col-lg-9 col-md-12 no-padding change-content">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> TẬP VIẾT TIẾNG ANH</h5>
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
            <button class="btn btn-sm btn-primary full-width margin-top">Tìm kiếm bài học</button>
	 	</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Bài mẫu Hệ Thống</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Bài Viết Của Bạn</a></li>
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
                            </tr>
                            @else
                            <tr id="{{$i}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
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
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Chia sẻ</button>
                                </td>
                            </tr>
                            @else
                            <tr id="{{$i}}">
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                                <td >
                                    <button class="btn btn-sm btn-default" type-btn="btn-forget">Chia sẻ</button>
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
            <ul class="nav nav-tabs nav-justified writing-tab">
                <li class="active"><a data-toggle="tab" href="#example">Xem Bài Viết Mẫu</a></li>
                <li><a data-toggle="tab" href="#practice">Bắt Đầu Tập Viết</a></li>
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
                <div id="practice" class="tab-pane fade input-tab">
                    <label class="title-header">Tiêu đề bài viết</label>
                    <input type="text" class="form-control input-sm margin-bottom" name="">
                    <label class="title-header">Nội dung bài viết</label>
                    <textarea name="practice-area" col-xs-12 no-paddings="5"></textarea>
                    <script type="text/javascript">
                      var editor = CKEDITOR.replace('practice-area',{language:"vi"});
                    </script>
                    <div class="col-xs-12 no-padding margin-top margin-bottom add-panel">
                        <div class="panel-group" id="add-list">
                            <div class="panel panel-default panel-contribute">
                             <div class="panel-heading" data-toggle="collapse" data-parent="#add-list" href="#collapse6">
                                <h5 class="panel-title">
                                  <span>Thêm Từ Vựng Cho Bài Viết</span>
                                </h5>
                              </div>
                              <div id="collapse6" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="col-sm-12 no-padding">
                                        <div class="form-group table-fixed-width" min-width="600px">
                                            <label>Danh Sách Từ Vựng</label>
                                            <table class="table table-bordered table-input" style="min-width: 600px;">
                                                <thead>
                                                    <tr>
                                                        <th><a id="btn-new-row" class="btn-add"><span class="fa fa-plus"></span></a></th>
                                                        <th>Tên</th>
                                                        <th>Phiên Âm</th>
                                                        <th>Nghĩa</th>
                                                        <th>Xóa</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="hidden">
                                                        <td></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                                                        <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                                                    </tr>
                                                                            <tr>
                                                        <td>1</td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                                                        <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                                                    </tr>
                                                                            <tr>
                                                        <td>2</td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                                                        <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                                                    </tr>
                                                                            <tr>
                                                        <td>3</td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                                                        <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                                                    </tr>
                                                                            <tr>
                                                        <td>4</td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                                                        <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                                                    </tr>
                                                                            <tr>
                                                        <td>5</td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="abide by"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="ə'baid"></td>
                                                        <td><input type="text" name="" class="form-control input-sm" value="Tôn trọng, tuân theo, giữ (lời)"></td>
                                                        <td><button type="button" class="btn-danger delete-tr-row"><span class="fa fa-close"></span></button></td>
                                                    </tr>
                                                                        </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div> 
                    </div>
                    <div class="margin-top margin-bottom">
                        <button class="btn btn-sm btn-default" >Làm Mới Trang</button>
                        <button class="btn btn-sm btn-primary" style="float: right;">Lưu Lại</button>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-xs-12 no-padding margin-top control-btn">
			<button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
            <button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
		</div>
        <div class="col-xs-12 no-padding margin-top list-panel">
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

