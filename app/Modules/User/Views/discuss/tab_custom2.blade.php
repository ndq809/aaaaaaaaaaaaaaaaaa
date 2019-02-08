<div class="form-group">
    <input type="hidden" id="new-question-id">
    <label class="title-header">Thêm tag cho câu hỏi</label>
    <select class="margin-bottom tag-selectize submit-item post_tag_new" id="new-question-tag" multiple="multiple">
        @if(isset($data_default[4])&&$data_default[4][0]['tag_id'] != '')
        @foreach($data_default[4] as $item)
            <option value="{{$item['tag_id']}}" data-data ="{{json_encode( $item)}}">{{$item['tag_nm']}}</option>
        @endforeach
        @endif
    </select>
</div>
<div class="form-group">
    <label class="title-header">Tiêu đề câu hỏi</label>
    <input type="text" class="form-control input-sm margin-bottom submit-item" id="new-question-title" name="">
</div>
<div class="form-group">
    <label class="title-header inline-block">Nội dung</label>
    <textarea name="post_content" class="col-xs-12 no-paddings submit-item ckeditor" rows="5" id="new-question-content"></textarea>
</div>
<div class="margin-top margin-bottom add-panel">
    <div class="margin-top btn-group">
        <button class="btn btn-sm btn-default" id="btn-clear">Xóa Trắng</button>
        <button class="btn btn-sm btn-success" id="btn-question">Đặt Câu Hỏi</button>
    </div> 
</div>
