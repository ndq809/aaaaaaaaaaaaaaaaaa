@extends('layout')
@section('title','E+ Giải Trí')
@section('asset_header')
    {!!WebFunctions::public_url('web-content/js/screen/relax.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/jquery.ratemate.js')!!}
    {!!WebFunctions::public_url('web-content/js/common/library/raphael-min.js')!!}
    {!!WebFunctions::public_url('web-content/css/screen/relax.css')!!}
    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
@stop

@section('content')
<div class="col-xs-12 no-padding">
	<div class="col-md-12 no-padding">
		<div class="right-header">
			<h5><i class="glyphicon glyphicon-education"></i> GIẢI TRÍ CÙNG TIẾNG ANH</h5>
		</div>
	</div>
	 <div class="col-md-4 col-md-push-8 right-tab no-padding">
	 	<div class="col-md-12 no-padding select-group">
	 		<div class="form-group">
                <label>Chủ đề</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Ngôn ngữ</label>
                <div class="input-group">
                    <select class="form-control input-sm">
                        <option>this is select box</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-sm btn-primary full-width margin-top">Xem bài viết / Làm mới</button>
	 	</div>
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true">Hình Ảnh</a></li>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false">Video</a></li>
            <li class=""><a data-toggle="tab" href="#tab3" aria-expanded="false">Truyện</a></li>
        </ul>
        <div class="tab-content focusable">
            <div id="tab1" class="tab-pane fade active in">
                <div class="">
                    <table class="table table-striped table-hover table-right relax-table">
                         @for($i=1;$i<=10;$i+=2)
                         @if($i==1)
                        <tbody id="{{$i}}" class="activeItem">
                            <tr>
                                <td><a><img alt="loadIcon" src="https://em.wattpad.com/eb561e9fdaaba1f8c44ffb1056263e39ddf6aa39/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f776174747061642d6d656469612d736572766963652f53746f7279496d6167652f5370696e526755417930576344673d3d2d3335373536333234362e313439393932656337353031383837323934303339393937393537332e6a7067?s=fit&amp;amp;w=1280&amp;amp;h=1280"></a></td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody id="{{$i+1}}">
                            <tr>
                                <td><a><img alt="loadIcon" src="http://anhdep99.com/wp-content/uploads/2016/12/anh-anime-dep-lung-linh-trong-dem-giang-sinh.jpg"></a></td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                            </tr>
                        </tbody>
                        @else
                        <tbody id="{{$i}}">
                            <tr>
                                <td><a><img alt="loadIcon" src="https://em.wattpad.com/eb561e9fdaaba1f8c44ffb1056263e39ddf6aa39/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f776174747061642d6d656469612d736572766963652f53746f7279496d6167652f5370696e526755417930576344673d3d2d3335373536333234362e313439393932656337353031383837323934303339393937393537332e6a7067?s=fit&amp;amp;w=1280&amp;amp;h=1280"></a></td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody id="{{$i+1}}">
                            <tr>
                                <td><a><img alt="loadIcon" src="http://anhdep99.com/wp-content/uploads/2016/12/anh-anime-dep-lung-linh-trong-dem-giang-sinh.jpg"></a></td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="radio-inline"><i class="glyphicon glyphicon-hand-right"> </i> <span> Abide by</span> </a>
                                </td>
                            </tr>
                        </tbody>
                        @endif
                        @endfor
                    </table>
                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
                <div class="">
                    <table class="table table-striped table-hover table-right">
                        <tbody>
                             @for($i=6;$i<=10;$i++)
                            @if($i==6)
                            <tr>
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
            <div id="tab3" class="tab-pane fade">
                <div class="">
                    <table class="table table-striped table-hover table-right">
                        <tbody>
                             @for($i=11;$i<=15;$i++)
                            @if($i==6)
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
        </div>
    </div>
	<div class="col-md-8 col-md-pull-4 web-main">
		<div class="col-xs-12 no-padding">
			<ul class="nav nav-tabs nav-justified Relax-tab">
                <li class="active"><a data-toggle="tab" href="#example">Giải trí với tiếng anh</a></li>
                <li><a data-toggle="tab" href="#question">Đóng góp cho E+</a></li>
            </ul>
            <div class="tab-content">
                <div id="example" class="tab-pane fade in active">
                    <div class="example-header title-header">
                        <span>Chủ Ngữ !</span>
                    </div>
                    <div class="main-content" id="noiDungNP">
                        <p>Chủ ngữ là chủ thể của hành động trong câu, thường đứng trước động từ (verb). Chủ ngữ thường là một danh từ (noun) hoặc một ngữ danh từ (noun phrase - một nhóm từ kết thúc bằng một danh từ, trong trường hợp này ngữ danh từ không được bắt đầu bằng một giới từ). Chủ ngữ thường đứng ở đầu câu và quyết định việc chia động từ.&nbsp;&nbsp;<br>
                        <div class="image margin-bottom">
                            <img alt="loadIcon" src="https://em.wattpad.com/eb561e9fdaaba1f8c44ffb1056263e39ddf6aa39/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f776174747061642d6d656469612d736572766963652f53746f7279496d6167652f5370696e526755417930576344673d3d2d3335373536333234362e313439393932656337353031383837323934303339393937393537332e6a7067?s=fit&amp;amp;w=1280&amp;amp;h=1280">
                        </div>
                    </div>
                </div>
                <div id="question" class="tab-pane fade input-tab">
                    <div class="form-group width-50 inline-block float-left">
                        <label class="title-header" style="display: inline-block;">Loại bài viết</label>
                        <div class="input-group">
                            <select class="form-control input-sm media-select">
                                <option value="1">Hình ảnh</option>
                                <option value="2">Video</option>
                                <option value="3">Truyện</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group width-50 inline-block float-left">
                        <label class="title-header" style="display: inline-block;">Ngôn ngữ</label>
                        <div class="input-group">
                            <select class="form-control input-sm media-select">
                                <option value="1">Tiếng anh</option>
                                <option value="2">Tiếng Việt</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="title-header">Tiêu đề bài viết</label>
                        <input type="text" class="form-control input-sm margin-bottom" name="">
                    </div>
                    <div class="form-group">
                        <label class="title-header">Mô tả</label>
                        <textarea class="form-control input-sm margin-bottom" rows="4"></textarea>
                    </div>
                    <div class="form-group link">
                        <label class="title-header">Đường dẫn ảnh / video</label>
                        <input type="text" class="form-control input-sm margin-bottom" name="">
                    </div>
                    <div class="form-group non-link">
                        <label class="title-header">Nội dung bài viết</label>
                        <textarea name="practice-area" col-xs-12 no-paddings="5"></textarea>
                        <script type="text/javascript">
                          var editor = CKEDITOR.replace('practice-area',{language:"vi"});
                        </script>
                    </div>
                    <div class="margin-top margin-bottom">
                        <button class="btn btn-sm btn-default" >Làm Mới Trang</button>
                        <button class="btn btn-sm btn-primary" style="float: right;">Đóng Góp</button>
                    </div>
                </div>
            </div>
		</div>
        <div class=" col-xs-12 no-padding rate-bar">
            <button class="btn btn-sm col-md-3 col-sm-3 col-xs-5"><span style="font-weight: bold;">Đánh giá</span></button>
            <div class="col-md-6 col-sm-6 col-xs-7">
                <input max="5.0" min="0.0" name="rating" type="number" value="0.0" id="rating-value">
            </div>
            <button class="btn btn-sm col-md-3 col-sm-3 col-xs-12 btn-popup" popup-id="popup-box2"><span style="font-weight: bold;">Báo Cáo Bài Viết !</span></button>
        </div>
		<div class="col-xs-12 no-padding margin-top router-btn">
			<button class="btn btn-sm btn-primary" id="btn_prev">Trước</button>
			<button class="btn btn-sm btn-primary" id="btn_next" style="float: right;">Tiếp</button>
		</div>
		<div class="col-xs-12 no-padding">
			<div class="margin-top commentbox">
                <div class="titleBox">
                    <label>Bình luận</label>
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                </div>

                <div class="actionBox" style="padding: 0px;">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" id="noiDungBL"
                                placeholder="Bình luận của bạn" />
                            <div class="input-group-btn">
                                <a class="btn btn-default btn-sm" id="btBinhLuan">Bình Luận </a>
                            </div>
                        </div>
                    </form>
                    <ul class="commentList" id="commentList">
                        <li id="bl3059">
                            <div class="commenterImage">
                                <img src="web-content/images/avarta/avarta.jpg">
                            </div>
                            <div class="commentText">
                                <p>quý nguyễn</p><span class="date sub-text">29-07-2017 17:09:40</span>
                            </div>
                        </li>
                        <li id="bl3059">
                            <div class="commenterImage">
                                <img src="web-content/images/avarta/avarta.jpg">
                            </div>
                            <div class="commentText">
                                <p>Bài viết rất hay</p><span class="date sub-text">29-07-2017 17:09:40</span>
                            </div>
                        </li>
                        <li id="bl3059">
                            <div class="commenterImage">
                                <img src="web-content/images/avarta/avarta.jpg">
                            </div>
                            <div class="commentText">
                                <p>hình như có chỗ chưa đúng</p><span class="date sub-text">29-07-2017 17:09:40</span>
                            </div>
                        </li>
                        <li id="bl3059">
                            <div class="commenterImage">
                                <img src="web-content/images/avarta/avarta.jpg">
                            </div>
                            <div class="commentText">
                                <p>đã học hehe</p><span class="date sub-text">29-07-2017 17:09:40</span>
                            </div>
                        </li>
                    </ul>
                    <div class="form-group">
                        <button class="btn btn-default btn-sm full-width">Hiện thêm bình luận</button>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>

@stop

