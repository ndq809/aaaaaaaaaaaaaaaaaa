<div class="col-lg-6 col-xs-12 no-padding">
    <div class="form-group">
        <label class="title-header">Loại bài viết</label>
        <select class="form-control input-sm submit-item" id="post_div">
            <option value="4">Hình ảnh</option>
            <option value="5">Video</option>
            <option value="6">Truyện</option>
        </select>
    </div>
</div>

<div class="col-lg-6 col-xs-12 no-padding">
    <div class="form-group">
        <label class="title-header">Ngôn ngữ</label>
        <select class="form-control input-sm submit-item" id="post_language">
            <option value="1">Tiếng việt</option>
            <option value="2">Tiếng anh</option>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="title-header">Thêm tag cho bài viết</label>
    <select class="margin-bottom tag-selectize submit-item post_tag_new" id="post_tag" multiple="multiple">
        @if(isset($data_default[4])&&$data_default[4][0]['tag_id'] != '')
        @foreach($data_default[4] as $item)
            <option value="{{$item['tag_id']}}" data-data ="{{json_encode( $item)}}">{{$item['tag_nm']}}</option>
        @endforeach
        @endif
    </select>
</div>
<div class="form-group">
    <label class="title-header">Tiêu đề bài viết</label>
    <input type="text" class="form-control input-sm margin-bottom submit-item" id="post_title" name="">
</div>
<form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
    <div class="form-group change-box" type = "4">
        <label>Hình Ảnh</label>
        <div class="input-group new-image">
            <input type="file" id="post_media" class="input-image-custom" name="post_media"  value="">
        </div>
    </div>
</form>
<div class="form-group change-box" type = "5">
    <label>Link video</label>
    <div class="input-group">
        <input type="text" id="post_media" class="form-control" placeholder="youtube/facebook video link">
    </div>
</div>
<div class="form-group">
    <label class="title-header inline-block">Nội dung</label>
    <textarea name="post_content" class="col-xs-12 no-paddings submit-item ckeditor" rows="5" id="post_content"></textarea>
</div>
<div class="margin-top margin-bottom add-panel">
    <div class="margin-top btn-group">
        <button class="btn btn-sm btn-default" id="btn-clear">Xóa Trắng</button>
        <button class="btn btn-sm btn-success" id="btn-share">Đăng Bài</button>
    </div> 
</div>
