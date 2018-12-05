<input type="hidden" id="row_id" class="submit-item">
<input type="hidden" id="post_id" class="submit-item">
<div class="form-group">
    <label class="title-header">Thêm tag cho bài viết</label>
    <select class="margin-bottom tag-selectize submit-item" id="post_tag_new" multiple="multiple">
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
    <label class="title-header inline-block">Nội dung</label>
    <textarea name="post_content" class="col-xs-12 no-paddings submit-item ckeditor" rows="5" id="post_content"></textarea>
</div>
<div class="margin-top margin-bottom add-panel">
    <div class="margin-top btn-group">
        <button class="btn btn-sm btn-default" id="btn-clear">Xóa Trắng</button>
        <button class="btn btn-sm btn-primary" id="btn-save-new" >Lưu Như Bài Viết Mới</button>
        <button class="btn btn-sm btn-info" id="btn-save">Lưu Lại</button>
        <button class="btn btn-sm btn-success" id="btn-share">Chia Sẻ</button>
        <button class="btn btn-sm btn-danger" id="btn-delete">Xóa Bài Viết</button>
    </div> 
</div>
