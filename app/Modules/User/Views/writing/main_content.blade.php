<div class="col-xs-12 no-padding">
    <ul class="nav nav-tabs nav-justified writing-tab">
        <li class="active"><a data-toggle="tab" href="#example">Xem Bài Viết Mẫu</a></li>
        <li><a data-toggle="tab" href="#practice">Bắt Đầu Tập Viết</a></li>
    </ul>
    <div class="tab-content">
        <div id="example" class="tab-pane fade in active">
            @if(isset($data)&&$data[2][0]['post_id'] != '')
                @foreach($data[2] as $index => $row)
                <div class="example-header title-header writing-box" target-id="{{$row['row_id']}}">
                    <span>{{$row['post_title']}}</span>
                </div>
                @endforeach
            @endif
           @if(isset($data)&&$data[2][0]['post_id'] != '')
                @foreach($data[2] as $index => $row)
                     <div class="main-content writing-box" id="noiDungNP" style="border-left: #ccc solid 1px; border-bottom: #ccc solid 1px;" target-id="{{$row['row_id']}}">
                        {!!$row['post_content']!!}
                    </div>
                @endforeach
            @endif
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
<div class="col-xs-12 no-padding">
      @include('vocabulary_content')
</div>
<div class="col-xs-12 no-padding margin-top">
    @include('comment_content')
</div>
<div class="col-xs-12 paging-list margin-top">
   @include('paging_content')
</div>
