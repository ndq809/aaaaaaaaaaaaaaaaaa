<input type="hidden" id="row_id" class="submit-item">
<input type="hidden" id="post_id" class="submit-item">
<div class="form-group">
    <label class="title-header">Thêm tag cho bài viết</label>
    <select class="margin-bottom tag-selectize submit-item" id="post_tag" multiple="multiple">
        @if(isset($data[6])&&$data[6][0]['tag_id'] != '')
        @foreach($data[6] as $item)
            <option value="{{$item['tag_id']}}">{{$item['tag_nm']}}</option>
        @endforeach
        @endif
    </select>
</div>
<div class="form-group">
    <label class="title-header">Tiêu đề bài viết</label>
    <input type="text" class="form-control input-sm margin-bottom submit-item" id="post_title" name="">
</div>
<div class="form-group">
    <label class="title-header inline-block">Nội dung bài viết</label>
     <label class="switch">
      <input type="checkbox" checked="checked" id="is_suggest">
      <span class="slider round"></span>
      <span class="switch-text title-header">Gợi ý ngữ pháp</span>
    </label>
    <textarea name="post_content" class="col-xs-12 no-paddings submit-item ckeditor" rows="5" id="post_content"></textarea>
    <div class="panel suggest-box">
        <div class="panel-body">
            <div class="form-group">
                <label>Danh Sách Ngữ Pháp Gợi ý: </label>
                <ul class="suggest-grammar">
                    
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 no-padding margin-top margin-bottom add-panel">
    <div class="panel-group" id="add-list">
        <div class="panel-group" id="example-list">
            <div class="panel panel-default panel-contribute">
             <div class="panel-heading" data-toggle="collapse" data-parent="#add-list" href="#collapse6">
                <h5 class="panel-title">
                  <span>Thêm Từ Vựng Cho Bài Viết</span>
                </h5>
              </div>
              <div id="collapse6" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="col-sm-12 no-padding">
                        <a class="btn btn-primary btn-sm btn-custom btn-add-vocabulary" href='/popup/p001' type="button">Duyệt danh sách từ vựng</a>
                        <div class="table-fixed-width" min-width="600px">
                            <table class="table table-bordered table-input vocabulary-table" style="min-width: 600px;">
                                <thead>
                                    <tr>
                                        <th width="40px">STT</th>
                                        <th>Tên</th>
                                        <th>Phiên Âm</th>
                                        <th>Nghĩa</th>
                                    </tr>
                                </thead>
                                <tbody id="voc-content">
                                    @if(isset($data)&&$data[4][0]['post_id'] != '')
                                        @include('User::writing.add_vocabulary',array('data'=>$data[4]))
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div> 
</div>
<div class="margin-top margin-bottom">
    <button class="btn btn-sm btn-default" id="btn-clear">Xóa Trắng</button>
    <button class="btn btn-sm btn-primary" id="btn-save-new" >Lưu Như Bài Viết Mới</button>
    <button class="btn btn-sm btn-primary" id="btn-save" style="float: right;">Lưu Lại</button>
    <button class="btn btn-sm btn-success" id="btn-share" style="float: right;margin-right: 10px">Chia Sẻ</button>
    <button class="btn btn-sm btn-danger" id="btn-delete" style="float: right;margin-right: 10px">Xóa Bài Viết</button>
</div>
